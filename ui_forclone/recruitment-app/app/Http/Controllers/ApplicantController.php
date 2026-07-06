<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the applicants.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Applicant::with(['applications.jobOpening.position']);

        if ($user->hasRole(['department_head', 'principal'])) {
            $deptId = $user->department_id;
            $query->whereHas('applications.jobOpening', function($q) use ($deptId) {
                $q->where('department_id', $deptId);
            });
        }

        $applicants = $query->latest()->paginate(15);
        
        // Stats for Dashboard-style UI
        $stats = [
            'total' => (clone $query)->count(),
            'new' => (clone $query)->where('created_at', '>=', now()->subDays(7))->count(),
            'shortlisted' => (clone $query)->whereHas('applications', function($q) {
                $q->where('decision_status', 'Shortlisted');
            })->count(),
        ];

        return view('admin.applicants.index', compact('applicants', 'stats'));
    }

    /**
     * Display the specified applicant.
     */
    public function show(string $id)
    {
        $applicant = Applicant::with([
            'applications.jobOpening.position.department',
            'applications.documents',
            'applications.interviews.scorecards.interviewer',
            'applications.notes.user'
        ])->findOrFail($id);

        return view('admin.applicants.show', compact('applicant'));
    }

    /**
     * Display a pipeline view of the applicants.
     */
    public function pipeline()
    {
        $user = auth()->user();
        $query = Applicant::with(['applications.jobOpening.position']);

        // Only filter by department if they are a head/principal AND NOT a super_admin/hr_admin
        if (!$user->hasRole(['super_admin', 'hr_admin']) && $user->hasRole(['department_head', 'principal'])) {
            $deptId = $user->department_id;
            $query->whereHas('applications.jobOpening', function($q) use ($deptId) {
                $q->where('department_id', $deptId);
            });
        }

        $allApplicants = $query->get();

        $stages = [
            'Application Received',
            'Screening',
            'Interview',
            'Shortlisted',
            'Offered',
            'Hired',
            'Rejected'
        ];

        $pipeline = [];
        foreach ($stages as $stage) {
            $pipeline[$stage] = $allApplicants->filter(function($applicant) use ($stage) {
                $firstApp = $applicant->applications->first();
                return $firstApp && $firstApp->current_stage === $stage;
            });
        }

        return view('admin.applicants.pipeline', compact('pipeline', 'stages'));
    }
}

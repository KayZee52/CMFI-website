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
        return view('admin.applicants.index', compact('applicants'));
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
}

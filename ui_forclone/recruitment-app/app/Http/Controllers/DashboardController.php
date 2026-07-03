<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\JobOpening;
use App\Models\ApplicationNote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Base queries
        $applicationQuery = Application::query();
        $jobQuery = JobOpening::query();
        $applicantQuery = Applicant::query();

        // Role-based filtering for Department Heads / Principal
        if ($user->hasRole(['department_head', 'principal'])) {
            $deptId = $user->department_id;
            
            $jobQuery->where('department_id', $deptId);
            $applicationQuery->whereHas('jobOpening', function($q) use ($deptId) {
                $q->where('department_id', $deptId);
            });
            $applicantQuery->whereHas('applications.jobOpening', function($q) use ($deptId) {
                $q->where('department_id', $deptId);
            });
        }

        // Stats
        $stats = [
            'total_applicants' => $applicantQuery->count(),
            'shortlisted' => (clone $applicationQuery)->where('decision_status', 'Shortlisted')->count(),
            'hired' => (clone $applicationQuery)->where('decision_status', 'Hired')->count(),
            'open_positions' => $jobQuery->where('status', 'Open')->count(),
        ];

        // Pipeline Counts for Chart
        $pipeline = [
            'Received' => (clone $applicationQuery)->where('current_stage', 'Application Received')->count(),
            'Screening' => (clone $applicationQuery)->where('current_stage', 'Phone Screening')->count(),
            'Shortlist' => (clone $applicationQuery)->where('decision_status', 'Shortlisted')->count(),
            'Interview' => (clone $applicationQuery)->where('current_stage', 'Interviewing')->count(),
            'Hired' => (clone $applicationQuery)->where('decision_status', 'Hired')->count(),
        ];

        // Recent Applicants
        $recentApplicants = (clone $applicantQuery)->latest()->take(3)->get();

        // Activity Feed (System logs)
        $activities = ApplicationNote::with(['application.applicant', 'user'])
            ->where('type', 'system')
            ->when($user->hasRole(['department_head', 'principal']), function($q) use ($user) {
                $q->whereHas('application.jobOpening', function($sq) use ($user) {
                    $sq->where('department_id', $user->department_id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentApplicants', 'activities', 'pipeline'));
    }
}

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
        $applicants = Applicant::with(['applications.jobOpening.position.department'])
            ->latest()
            ->paginate(15);

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

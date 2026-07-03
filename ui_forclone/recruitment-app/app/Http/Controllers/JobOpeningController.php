<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOpening;
use App\Models\Position;
use App\Models\AcademicYear;

class JobOpeningController extends Controller
{
    /**
     * Display a listing of the job openings.
     */
    public function index()
    {
        $openings = JobOpening::with(['position.department', 'academicYear'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => JobOpening::count(),
            'open' => JobOpening::where('status', 'open')->count(),
            'vacancies' => JobOpening::where('status', 'open')->sum('vacancies'),
        ];

        return view('admin.job_openings.index', compact('openings', 'stats'));
    }

    /**
     * Show the form for creating a new job opening.
     */
    public function create()
    {
        $positions = Position::with('department')->get();
        $academicYears = AcademicYear::all();
        $currentYear = AcademicYear::where('is_current', true)->first();

        return view('admin.job_openings.create', compact('positions', 'academicYears', 'currentYear'));
    }

    /**
     * Store a newly created job opening in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'vacancies' => 'required|integer|min:1',
            'closing_date' => 'nullable|date|after:today',
            'status' => 'required|in:open,closed,filled',
        ]);

        JobOpening::create($validated);

        return redirect()->route('job-openings.index')->with('success', 'Job opening created successfully.');
    }

    /**
     * Show the form for editing the specified job opening.
     */
    public function edit(JobOpening $jobOpening)
    {
        $positions = Position::with('department')->get();
        $academicYears = AcademicYear::all();

        return view('admin.job_openings.edit', compact('jobOpening', 'positions', 'academicYears'));
    }

    /**
     * Update the specified job opening in storage.
     */
    public function update(Request $request, JobOpening $jobOpening)
    {
        $validated = $request->validate([
            'vacancies' => 'required|integer|min:1',
            'closing_date' => 'nullable|date',
            'status' => 'required|in:open,closed,filled',
        ]);

        $jobOpening->update($validated);

        return redirect()->route('job-openings.index')->with('success', 'Job opening updated successfully.');
    }

    /**
     * Remove the specified job opening from storage.
     */
    public function destroy(JobOpening $jobOpening)
    {
        $jobOpening->delete();

        return redirect()->route('job-openings.index')->with('success', 'Job opening deleted successfully.');
    }
}

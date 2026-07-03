<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\JobOpening;
use App\Models\AcademicYear;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PublicApplicationController extends Controller
{
    public function index()
    {
        $openings = JobOpening::with('position.department')->where('status', 'open')->get();
        return view('apply', compact('openings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email',
            'phone' => 'required|string|max:20',
            'job_opening_id' => 'required|exists:job_openings,id',
            'applicant_type' => 'required|in:new,current_teacher',
            'staff_id' => 'required_if:applicant_type,current_teacher|nullable|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // 1. Create or Find Applicant
            $applicant = Applicant::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'applicant_type' => $validated['applicant_type'],
                'staff_id' => $validated['staff_id'],
            ]);

            // 2. Create Application
            $application = Application::create([
                'applicant_id' => $applicant->id,
                'job_opening_id' => $validated['job_opening_id'],
                'reference_number' => 'APP-' . strtoupper(Str::random(8)),
                'submitted_at' => now(),
            ]);

            // 3. Handle File Upload
            if ($request->hasFile('cv')) {
                $path = $request->file('cv')->store('applications/cvs', 'private');
                $application->documents()->create([
                    'document_type' => 'CV',
                    'file_path' => $path,
                    'original_filename' => $request->file('cv')->getClientOriginalName(),
                ]);
            }

            return redirect()->route('apply')->with('success', 'Application submitted successfully! Reference: ' . $application->reference_number);
        });
    }
}

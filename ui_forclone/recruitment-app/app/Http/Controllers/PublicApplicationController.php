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
            // Section 1
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email',
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'home_address' => 'nullable|string',
            
            // Section 2
            'job_opening_id' => 'required|exists:job_openings,id',
            'applicant_type' => 'required|in:new,current_teacher',
            'subjects_can_teach' => 'nullable|string',
            
            // Section 3
            'highest_qualification' => 'nullable|string',
            'institution' => 'nullable|string',
            'graduation_year' => 'nullable|integer',
            'major' => 'nullable|string',
            
            // Section 4
            'years_experience' => 'nullable|integer',
            'previous_school' => 'nullable|string',
            'prev_position' => 'nullable|string',
            'prev_period' => 'nullable|string',
            
            // Section 6
            'dismissed' => 'nullable|string',
            'convicted' => 'nullable|string',
            'abide_policies' => 'nullable|string',
            
            // Section 7
            'personal_statement' => 'nullable|string',
            
            // Files
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'academic_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'id_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // 1. Create Applicant
            $applicant = Applicant::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'home_address' => $validated['home_address'],
                'applicant_type' => $validated['applicant_type'],
                'highest_qualification' => $validated['highest_qualification'],
                'institution' => $validated['institution'],
                'graduation_year' => $validated['graduation_year'],
                'major' => $validated['major'],
                'years_experience' => $validated['years_experience'] ?? 0,
                'dismissed' => $validated['dismissed'] ?? 'No',
                'convicted' => $validated['convicted'] ?? 'No',
                'abide_policies' => $validated['abide_policies'] ?? 'Yes',
            ]);

            // 2. Create Application
            $application = Application::create([
                'applicant_id' => $applicant->id,
                'job_opening_id' => $validated['job_opening_id'],
                'applicant_type' => $validated['applicant_type'] === 'new' ? 'New Applicant' : 'Current Teacher (Reapplying)',
                'subjects_can_teach' => $validated['subjects_can_teach'],
                'personal_statement' => $validated['personal_statement'],
                'previous_school' => $validated['previous_school'],
                'prev_position' => $validated['prev_position'],
                'prev_period' => $validated['prev_period'],
                'reference_number' => 'APP-' . strtoupper(Str::random(8)),
                'submitted_at' => now(),
            ]);

            // 3. Handle File Uploads
            $fileFields = [
                'cv' => 'CV',
                'academic_certificate' => 'Academic Certificate',
                'photo' => 'Passport Photo',
                'id_card' => 'ID Card',
            ];

            foreach ($fileFields as $field => $type) {
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store('applications/' . Str::plural(strtolower($field)), 'private');
                    $application->documents()->create([
                        'document_type' => $type,
                        'file_path' => $path,
                        'original_filename' => $request->file($field)->getClientOriginalName(),
                    ]);
                }
            }

            // 4. Log Activity
            $application->logActivity('Application submitted via public portal.', null);

            return redirect()->route('apply')->with('success', 'Application submitted successfully! Our recruitment team will review your application soon.');
        });
    }
}

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
            // Section 1: Personal
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string',
            'city_of_residence' => 'required|string',
            'phone' => 'required|string',
            'whatsapp_number' => 'nullable|string',
            'email' => 'required|email|unique:applicants,email',
            'home_address' => 'required|string',
            
            // Section 2: Position
            'applicant_type' => 'required|in:new,current_teacher',
            'job_opening_id' => 'required|exists:job_openings,id',
            'subjects_can_teach' => 'nullable|string',
            'grades_preferred' => 'nullable|string',
            
            // Section 3: Education
            'highest_qualification' => 'required|string',
            'institution' => 'required|string',
            'graduation_year' => 'required|integer',
            'major' => 'nullable|string',
            
            // Section 4: Experience
            'years_experience' => 'required|integer',
            'previous_school' => 'nullable|string',
            'prev_position' => 'nullable|string',
            
            // Section 5: Reapplication (Conditional)
            'current_dept' => 'required_if:applicant_type,current_teacher|nullable|string',
            'years_served' => 'required_if:applicant_type,current_teacher|nullable|integer',
            'achievements' => 'nullable|string',
            
            // Section 6: Conduct
            'dismissed' => 'required|string',
            'convicted' => 'required|string',
            'abide_policies' => 'required|string',
            
            // Section 7: Availability
            'available_start_date' => 'required|date',
            'reference_data' => 'nullable|string',
            
            // Section 8: Final
            'personal_statement' => 'nullable|string',
            
            // Files
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // Split full name
            $names = explode(' ', $validated['full_name'], 2);
            $firstName = $names[0];
            $lastName = isset($names[1]) ? $names[1] : '';

            // 1. Create or update Applicant
            $applicant = Applicant::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'nationality' => $validated['nationality'],
                'city_of_residence' => $validated['city_of_residence'],
                'home_address' => $validated['home_address'],
                'highest_qualification' => $validated['highest_qualification'],
                'institution' => $validated['institution'],
                'graduation_year' => $validated['graduation_year'],
                'major' => $validated['major'],
                'years_experience' => $validated['years_experience'],
                'dismissed' => $validated['dismissed'],
                'convicted' => $validated['convicted'],
                'abide_policies' => $validated['abide_policies'],
                'applicant_type' => $validated['applicant_type'],
            ]);

            // 2. Create Application
            $application = Application::create([
                'applicant_id' => $applicant->id,
                'job_opening_id' => $validated['job_opening_id'],
                'applicant_type' => $validated['applicant_type'] === 'new' ? 'New Applicant' : 'Current Teacher (Reapplying)',
                'subjects_can_teach' => $validated['subjects_can_teach'],
                'grades_preferred' => $validated['grades_preferred'],
                'previous_school' => $validated['previous_school'],
                'prev_position' => $validated['prev_position'],
                'current_dept' => $validated['current_dept'],
                'years_served' => $validated['years_served'],
                'achievements' => $validated['achievements'],
                'available_start_date' => $validated['available_start_date'],
                'reference_data' => $validated['reference_data'],
                'personal_statement' => $validated['personal_statement'],
                'reference_number' => 'APP-' . strtoupper(Str::random(8)),
                'submitted_at' => now(),
            ]);

            // 3. Handle File Uploads
            if ($request->hasFile('cv')) {
                $path = $request->file('cv')->store('applications/cvs', 'private');
                $application->documents()->create([
                    'document_type' => 'CV',
                    'file_path' => $path,
                    'original_filename' => $request->file('cv')->getClientOriginalName(),
                ]);
            }

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('applications/photos', 'private');
                $application->documents()->create([
                    'document_type' => 'Passport Photo',
                    'file_path' => $path,
                    'original_filename' => $request->file('photo')->getClientOriginalName(),
                ]);
            }

            // 4. Log Activity
            $application->logActivity('Application submitted via public portal.', null);

            return redirect()->route('apply')->with('success', 'Your application for the 2026/2027 Academic Year has been successfully submitted! Our team will review it and contact you via email.');
        });
    }
}

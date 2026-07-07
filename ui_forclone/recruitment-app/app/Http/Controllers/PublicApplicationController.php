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
            'whatsapp_number' => 'required|string',
            'email' => 'required|email|unique:applicants,email',
            'home_address' => 'required|string',
            'emergency_name' => 'required|string',
            'emergency_number' => 'required|string',
            
            // Section 2: Position
            'applicant_type' => 'required|in:new,current_teacher',
            'position_applying_for' => 'required|string',
            'other_position' => 'nullable|string',
            'subjects_can_teach' => 'required|string',
            'grades_preferred' => 'nullable|string',
            
            // Section 3: Education
            'highest_qualification' => 'required|string',
            'institution' => 'required|string',
            'graduation_year' => 'required|integer',
            'major' => 'nullable|string',
            'certifications' => 'nullable|string',
            
            // Section 4: Experience
            'years_experience' => 'required|integer',
            'previous_school' => 'nullable|string',
            'prev_position' => 'nullable|string',
            'prev_period' => 'nullable|string',
            'prev_school_2' => 'nullable|string',
            'prev_position_2' => 'nullable|string',
            'prev_period_2' => 'nullable|string',
            
            // Section 5: Reapplication (Conditional)
            'current_dept' => 'required_if:applicant_type,current_teacher|nullable|string',
            'years_served' => 'required_if:applicant_type,current_teacher|nullable|integer',
            'achievements' => 'nullable|string',
            'challenges' => 'nullable|string',
            'why_continue' => 'nullable|string',
            
            // Section 6: Skills
            'skills_proficiency' => 'nullable|array',
            
            // Section 7: Conduct
            'dismissed' => 'required|string',
            'convicted' => 'required|string',
            'abide_policies' => 'required|string',
            
            // Section: Secondary History
            'secondary_employment' => 'nullable|array',
            
            // Section 8: References
            'references' => 'nullable|array',
            
            // Section 9: Availability
            'available_start_date' => 'required|date',
            'commitment_type' => 'required|string',
            'other_commitments' => 'nullable|string',
            
            // Section 10: Final
            'personal_statement' => 'required|string',
            'digital_signature' => 'required|string',
            
            // Files
            'cv' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'transcripts' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'academic_certificates' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'professional_certificates' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'identification_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'police_clearance' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'recommendation_letters' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        try {
            $application = DB::transaction(function () use ($request, $validated) {
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
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'nationality' => $validated['nationality'],
                'city_of_residence' => $validated['city_of_residence'],
                'home_address' => $validated['home_address'],
                'emergency_name' => $validated['emergency_name'],
                'emergency_number' => $validated['emergency_number'],
                'highest_qualification' => $validated['highest_qualification'],
                'institution' => $validated['institution'],
                'graduation_year' => $validated['graduation_year'],
                'major' => $validated['major'] ?? null,
                'certifications' => $validated['certifications'] ?? null,
                'years_experience' => $validated['years_experience'],
                'skills_proficiency' => $validated['skills_proficiency'] ?? [],
                'dismissed' => $validated['dismissed'],
                'convicted' => $validated['convicted'],
                'abide_policies' => $validated['abide_policies'],
                'applicant_type' => $validated['applicant_type'],
            ]);

            // 2. Handle Profile Photo separately (Public)
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store("applicants/photos", 'public');
                $applicant->update(['photo_path' => $photoPath]);
            }

            // 3. Create Application
            $opening = JobOpening::whereHas('position', function($q) use ($validated) {
                $q->where('title', $validated['position_applying_for']);
            })->first();

            $application = Application::create([
                'applicant_id' => $applicant->id,
                'job_opening_id' => $opening ? $opening->id : null,
                'position_applying_for' => $validated['position_applying_for'],
                'applicant_type' => $validated['applicant_type'] === 'new' ? 'New Applicant' : 'Current Teacher (Reapplying)',
                'subjects_can_teach' => $validated['subjects_can_teach'] ?? null,
                'grades_preferred' => $validated['grades_preferred'] ?? null,
                'previous_school' => $validated['previous_school'] ?? null,
                'prev_position' => $validated['prev_position'] ?? null,
                'prev_period' => $validated['prev_period'] ?? null,
                'prev_school_2' => $validated['prev_school_2'] ?? null,
                'prev_position_2' => $validated['prev_position_2'] ?? null,
                'prev_period_2' => $validated['prev_period_2'] ?? null,
                'current_dept' => $validated['current_dept'] ?? null,
                'years_served' => $validated['years_served'] ?? null,
                'achievements' => $validated['achievements'] ?? null,
                'challenges' => $validated['challenges'] ?? null,
                'why_continue' => $validated['why_continue'] ?? null,
                'available_start_date' => $validated['available_start_date'],
                'commitment_type' => $validated['commitment_type'],
                'other_commitments' => $validated['other_commitments'] ?? null,
                'secondary_employment' => $validated['secondary_employment'] ?? [],
                'other_position' => $validated['other_position'] ?? null,
                'digital_signature' => $validated['digital_signature'] ?? null,
                'reference_data' => $validated['references'] ?? [],
                'personal_statement' => $validated['personal_statement'] ?? null,
                'reference_number' => 'APP-' . strtoupper(Str::random(8)),
                'submitted_at' => now(),
            ]);

            // 4. Handle File Uploads (Private)
            $fileFields = [
                'cv' => 'CV',
                'transcripts' => 'Transcripts',
                'academic_certificates' => 'Academic Certificates',
                'professional_certificates' => 'Professional Certificates',
                'identification_card' => 'Identification Card',
                'police_clearance' => 'Police Clearance',
                'recommendation_letters' => 'Recommendation Letters',
            ];

            foreach ($fileFields as $field => $label) {
                if ($request->hasFile($field)) {
                    $folder = Str::plural(Str::snake($label));
                    $path = $request->file($field)->store("applications/{$folder}", 'private');
                    $application->documents()->create([
                        'document_type' => $label,
                        'file_path' => $path,
                        'original_filename' => $request->file($field)->getClientOriginalName(),
                    ]);
                }
            }

            // 4. Log Activity
            $application->logActivity('Application submitted via public portal.', null);

                return $application;
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Application submission failed: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An unexpected error occurred while saving your application. Please try again. (' . $e->getMessage() . ')']);
        }

        // 5. Send Confirmation Email (After Response)
        $applicant = $application->applicant;
        
        dispatch(function () use ($applicant, $application) {
            try {
                // Send Confirmation to Applicant
                \Illuminate\Support\Facades\Mail::to($applicant->email)->send(new \App\Mail\ApplicationConfirmation($application));
                
                // Send Notification to Admin
                \Illuminate\Support\Facades\Mail::to('admin@cmfischool.online')->send(new \App\Mail\AdminApplicationNotification($application));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send application emails: " . $e->getMessage());
            }
        })->afterResponse();

        return redirect()->route('apply')->with('success', 'Your application for the 2026/2027 Academic Year has been successfully submitted! Our team will review it and contact you via email.');
    }
}

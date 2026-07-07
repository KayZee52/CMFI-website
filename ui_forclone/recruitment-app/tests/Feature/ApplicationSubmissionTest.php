<?php

namespace Tests\Feature;

use App\Models\JobOpening;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create necessary data for the form
        $dept = Department::create(['name' => 'IT', 'code' => 'IT01']);
        $pos = Position::create(['title' => 'Software Developer', 'department_id' => $dept->id]);
        $ay = \App\Models\AcademicYear::create(['name' => '2026/2027', 'start_date' => '2026-09-01', 'end_date' => '2027-06-30', 'is_current' => true]);
        
        JobOpening::create([
            'position_id' => $pos->id,
            'academic_year_id' => $ay->id,
            'status' => 'open',
            'vacancies' => 1,
        ]);
    }

    public function test_can_submit_application_with_image_cv()
    {
        Storage::fake('private');
        $file = UploadedFile::fake()->image('my_cv.png');

        $response = $this->post('/apply', [
            'applicant_type' => 'new',
            'full_name' => 'John Doe',
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'nationality' => 'Cameroonian',
            'city_of_residence' => 'Douala',
            'phone' => '123456789',
            'whatsapp_number' => '123456789',
            'email' => 'john@example.com',
            'home_address' => 'Test Street',
            'emergency_name' => 'Jane Doe',
            'emergency_number' => '987654321',
            'position_applying_for' => 'Software Developer',
            'subjects_can_teach' => 'Math',
            'grades_preferred' => 'Grade 10',
            'commitment_type' => 'Full-Time',
            'available_start_date' => '2026-09-01',
            'highest_qualification' => "Bachelor's Degree",
            'institution' => 'University of Douala',
            'graduation_year' => 2015,
            'years_experience' => 5,
            'previous_school' => 'Old School',
            'prev_position' => 'Teacher',
            'prev_period' => '2020-2025',
            'dismissed' => 'No',
            'convicted' => 'No',
            'abide_policies' => 'Yes',
            'personal_statement' => 'I am a great candidate.',
            'digital_signature' => 'John Doe',
            'cv' => $file, // Use the defined $file
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/apply');
        $response->assertSessionHas('success');

        // Check if file exists in private storage
        Storage::disk('private')->assertExists('applications/c_vs/' . $file->hashName());
    }

    public function test_form_retains_old_input_on_validation_failure()
    {
        $response = $this->post('/apply', [
            'full_name' => 'Persistent Name',
            // Missing many required fields to trigger validation error
        ]);

        $response->assertStatus(302);
        $this->assertEquals('Persistent Name', old('full_name'));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Position;
use App\Models\JobOpening;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Roles
        $roles = ['super_admin', 'hr_admin', 'principal', 'department_head', 'interviewer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@cmfischool.online'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('super_admin');

        // 3. Academic Year
        $currentYear = AcademicYear::firstOrCreate(
            ['name' => '2026/2027'],
            [
                'is_current' => true,
                'start_date' => '2026-09-01',
                'end_date' => '2027-07-31',
            ]
        );

        // 4. Departments
        $depts = [
            ['name' => 'Science', 'code' => 'SCI'],
            ['name' => 'Arts & Humanities', 'code' => 'ART'],
            ['name' => 'Mathematics', 'code' => 'MAT'],
            ['name' => 'Primary Education', 'code' => 'PRI'],
        ];

        foreach ($depts as $dept) {
            $department = Department::firstOrCreate(['name' => $dept['name']], ['code' => $dept['code']]);

            // 5. Positions
            if ($dept['name'] === 'Science') {
                $pos = Position::firstOrCreate(
                    ['title' => 'Biology Teacher', 'department_id' => $department->id],
                    ['description' => 'Teach Biology to Grade 10-12']
                );

                // 6. Job Opening
                $opening = JobOpening::firstOrCreate(
                    ['position_id' => $pos->id, 'academic_year_id' => $currentYear->id],
                    ['vacancies' => 2, 'status' => 'open', 'closing_date' => '2026-08-15']
                );

                // 7. Mock Applicants
                $applicantsData = [
                    ['first' => 'John', 'last' => 'Doe', 'email' => 'john.doe@example.com', 'type' => 'new'],
                    ['first' => 'Jane', 'last' => 'Smith', 'email' => 'jane.smith@cmfischool.online', 'type' => 'current_teacher', 'staff' => 'CMFI-T-001'],
                    ['first' => 'Michael', 'last' => 'Johnson', 'email' => 'm.johnson@example.com', 'type' => 'new'],
                ];

                foreach ($applicantsData as $data) {
                    $applicant = Applicant::create([
                        'first_name' => $data['first'],
                        'last_name' => $data['last'],
                        'email' => $data['email'],
                        'phone' => '080' . rand(11111111, 99999999),
                        'applicant_type' => $data['type'],
                        'staff_id' => $data['staff'] ?? null,
                    ]);

                    $app = Application::create([
                        'applicant_id' => $applicant->id,
                        'job_opening_id' => $opening->id,
                        'reference_number' => 'APP-' . strtoupper(\Illuminate\Support\Str::random(8)),
                        'current_stage' => 'Application Received',
                        'submitted_at' => now(),
                    ]);

                    $app->notes()->create([
                        'user_id' => $admin->id,
                        'content' => 'Initial review pending. Appears to have required certifications.',
                    ]);
                }
            }
        }
    }
}

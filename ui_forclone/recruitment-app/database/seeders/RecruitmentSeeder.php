<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Position;
use App\Models\JobOpening;
use App\Models\Applicant;
use App\Models\Application;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = ['super_admin', 'hr_admin', 'principal', 'department_head', 'interviewer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Departments
        $depts = [
            ['name' => 'Science', 'code' => 'SCI'],
            ['name' => 'Arts & Humanities', 'code' => 'ART'],
            ['name' => 'Mathematics', 'code' => 'MAT'],
            ['name' => 'Primary Education', 'code' => 'PRI'],
        ];

        $departments = collect();
        foreach ($depts as $dept) {
            $departments->push(Department::firstOrCreate(['name' => $dept['name']], ['code' => $dept['code']]));
        }

        // 3. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'simeonojong@cmfischool.online'],
            [
                'name' => 'Simeon Ojong',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('super_admin');

        // 4. Principal & Heads
        if (!User::where('email', 'principal@cmfischool.online')->exists()) {
            $principal = User::create([
                'name' => 'CMFI Principal',
                'email' => 'principal@cmfischool.online',
                'password' => Hash::make('password'),
                'department_id' => $departments->first()->id,
            ]);
            $principal->assignRole('principal');
        }

        if (!User::where('email', 'science.head@cmfischool.online')->exists()) {
            $deptHead = User::create([
                'name' => 'Science Dept Head',
                'email' => 'science.head@cmfischool.online',
                'password' => Hash::make('password'),
                'department_id' => $departments->where('name', 'Science')->first()->id ?? $departments->first()->id,
            ]);
            $deptHead->assignRole('department_head');
        }

        // 5. Academic Year
        $currentYear = AcademicYear::firstOrCreate(
            ['name' => '2026/2027'],
            [
                'start_date' => '2026-09-01',
                'end_date' => '2027-07-31',
                'is_active' => true
            ]
        );

        // 6. Positions
        $posData = [
            ['title' => 'Senior Biology Teacher', 'department_id' => $departments->where('name', 'Science')->first()->id],
            ['title' => 'Junior Mathematics Teacher', 'department_id' => $departments->where('name', 'Mathematics')->first()->id],
            ['title' => 'Class Teacher (Grade 3)', 'department_id' => $departments->where('name', 'Primary Education')->first()->id],
        ];

        $positions = collect();
        foreach ($posData as $pos) {
            $positions->push(Position::firstOrCreate(['title' => $pos['title']], ['department_id' => $pos['department_id']]));
        }

        // 7. Job Openings
        foreach ($positions as $position) {
            JobOpening::firstOrCreate(
                ['position_id' => $position->id, 'academic_year_id' => $currentYear->id],
                [
                    'vacancies' => 2,
                    'status' => 'Open',
                    'closing_date' => now()->addMonths(2),
                ]
            );
        }

        // 8. Mock Applicants
        if (Applicant::count() === 0) {
            $jobOpening = JobOpening::first();
            
            $mockApplicants = [
                ['first_name' => 'Adebayo', 'last_name' => 'Chinedu', 'email' => 'adebayo@example.com'],
                ['first_name' => 'Sarah', 'last_name' => 'Oluchi', 'email' => 'sarah@example.com'],
                ['first_name' => 'Ibrahim', 'last_name' => 'Musa', 'email' => 'musa@example.com'],
            ];

            foreach ($mockApplicants as $data) {
                $applicant = Applicant::create(array_merge($data, [
                    'phone' => '080' . rand(10000000, 99999999),
                    'gender' => 'Other',
                    'date_of_birth' => '1990-01-01',
                    'address' => 'Lagos, Nigeria',
                ]));

                Application::create([
                    'applicant_id' => $applicant->id,
                    'job_opening_id' => $jobOpening->id,
                    'reference_number' => 'APP-' . strtoupper(Str::random(6)),
                    'current_stage' => 'Application Received',
                    'submitted_at' => now(),
                ]);
            }
        }
    }
}

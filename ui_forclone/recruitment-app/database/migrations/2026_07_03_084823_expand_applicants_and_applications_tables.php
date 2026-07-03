<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('nationality')->nullable()->after('date_of_birth');
            $table->string('city_of_residence')->nullable()->after('nationality');
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->string('emergency_name')->nullable()->after('address');
            $table->string('emergency_number')->nullable()->after('emergency_name');
            $table->string('highest_qualification')->nullable();
            $table->string('institution')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->string('major')->nullable();
            $table->text('certifications')->nullable();
            $table->integer('years_experience')->default(0);
            $table->json('skills_proficiency')->nullable();
            $table->string('dismissed')->default('No');
            $table->string('convicted')->default('No');
            $table->string('abide_policies')->default('Yes');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->string('applicant_type')->default('New Applicant')->after('applicant_id');
            $table->string('position_applying_for')->nullable()->after('job_opening_id');
            $table->string('subjects_can_teach')->nullable();
            $table->string('grades_preferred')->nullable();
            $table->json('reference_data')->nullable();
            $table->date('available_start_date')->nullable();
            $table->string('commitment_type')->default('Full-Time');
            $table->text('personal_statement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'nationality', 'city_of_residence', 'whatsapp_number', 
                'emergency_name', 'emergency_number', 'highest_qualification', 
                'institution', 'graduation_year', 'major', 'certifications', 
                'years_experience', 'skills_proficiency', 'dismissed', 
                'convicted', 'abide_policies'
            ]);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'applicant_type', 'position_applying_for', 'subjects_can_teach', 
                'grades_preferred', 'reference_data', 'available_start_date', 
                'commitment_type', 'personal_statement'
            ]);
        });
    }
};

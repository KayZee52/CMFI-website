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
            $table->text('home_address')->nullable()->after('address');
        });

        Schema::table('applications', function (Blueprint $table) {
            // Work History
            $table->string('previous_school')->nullable();
            $table->string('prev_position')->nullable();
            $table->string('prev_subjects')->nullable();
            $table->string('prev_period')->nullable();
            $table->string('new_app_employer1')->nullable();
            $table->string('new_app_employer2')->nullable();
            
            // Current Teacher Reapplication
            $table->string('current_dept')->nullable();
            $table->integer('years_served')->nullable();
            $table->text('achievements')->nullable();
            $table->text('challenges')->nullable();
            $table->text('why_continue')->nullable();
            
            // Availability
            $table->text('other_commitments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['home_address']);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'previous_school', 'prev_position', 'prev_subjects', 'prev_period',
                'new_app_employer1', 'new_app_employer2', 'current_dept', 
                'years_served', 'achievements', 'challenges', 'why_continue', 
                'other_commitments'
            ]);
        });
    }
};

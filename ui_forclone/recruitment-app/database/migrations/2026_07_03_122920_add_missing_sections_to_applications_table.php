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
        Schema::table('applications', function (Blueprint $table) {
            $table->json('secondary_employment')->nullable()->after('rejection_reason');
            $table->json('teaching_history_detailed')->nullable()->after('secondary_employment');
            $table->string('subject_specialty')->nullable()->after('teaching_history_detailed');
            $table->string('other_position')->nullable()->after('subject_specialty');
            $table->string('digital_signature')->nullable()->after('other_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'secondary_employment', 
                'teaching_history_detailed', 
                'subject_specialty', 
                'other_position', 
                'digital_signature'
            ]);
        });
    }
};

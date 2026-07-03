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
            $table->string('prev_school_2')->nullable()->after('prev_period');
            $table->string('prev_position_2')->nullable()->after('prev_school_2');
            $table->string('prev_period_2')->nullable()->after('prev_position_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['prev_school_2', 'prev_position_2', 'prev_period_2']);
        });
    }
};

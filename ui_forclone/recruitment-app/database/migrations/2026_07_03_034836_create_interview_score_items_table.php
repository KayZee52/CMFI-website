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
        Schema::create('interview_score_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scorecard_id')->constrained()->onDelete('cascade');
            $table->string('criteria'); // subject mastery, communication, etc.
            $table->integer('score'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_score_items');
    }
};

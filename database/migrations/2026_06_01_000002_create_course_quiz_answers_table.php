<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_quiz_attempt_id')->constrained('course_quiz_attempts')->cascadeOnDelete();

            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('question_option_id')->nullable()->constrained('question_options')->cascadeOnDelete();

            $table->boolean('is_correct')->default(false);
            $table->integer('points_earned')->default(0);

            $table->timestamps();

            $table->index(['course_quiz_attempt_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_quiz_answers');
    }
};

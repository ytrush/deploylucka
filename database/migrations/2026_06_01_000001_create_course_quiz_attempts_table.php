<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('type', 20); // pretest | posttest

            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('total_points');
            $table->integer('earned_points');
            $table->integer('percentage');
            $table->boolean('passed')->default(false);

            $table->timestamps();

            $table->index(['course_id', 'type', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_quiz_attempts');
    }
};

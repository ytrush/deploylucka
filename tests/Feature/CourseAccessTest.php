<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CourseAccessTest extends TestCase
{
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('comments');
        Schema::dropIfExists('materis');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();
        });

        Schema::create('materis', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('materi_id')->nullable()->constrained('materis')->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('materis');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_course_detail_page_is_accessible_to_non_enrolled_users(): void
    {
        $user = User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $course = Course::create([
            'instructor_id' => $user->id,
            'title' => 'Introduction to Laravel',
            'description' => 'A sample course',
            'level' => 'Beginner',
        ]);

        $response = $this->actingAs($user)->get('/courses/' . $course->id);

        $response->assertStatus(200);
        $response->assertSee($course->title);
    }
}

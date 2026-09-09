<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseViewCountTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_view_count_increases_once_per_session(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
        ]);

        $course = new Course([
            'title' => 'Course Uji',
            'description' => 'Deskripsi test',
            'level' => 'Beginner',
        ]);
        $course->save();

        $this->actingAs($user)
            ->withSession(['visited_courses' => []])
            ->get(route('courses.show', $course))
            ->assertOk();

        $this->assertSame(1, $course->fresh()->view_count);

        $this->actingAs($user)
            ->withSession(['visited_courses' => [$course->id]])
            ->get(route('courses.show', $course))
            ->assertOk();

        $this->assertSame(1, $course->fresh()->view_count);
    }
}

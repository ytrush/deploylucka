<section id="mentors" class="py-24 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold">Our Expert Instructors</h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Learn from our dedicated instructors who bring real-world experience to every course.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $instructors = \App\Models\Instructor::with(['courses.category', 'courses.enrollments'])
                    ->withCount('courses')
                    ->orderByDesc('courses_count')
                    ->take(3)
                    ->get();

                $mentors = $instructors->map(function ($instructor) {
                    $courseIds = $instructor->courses->pluck('id');
                    $students = \App\Models\Enrollment::whereIn('course_id', $courseIds)->count();
                    $skills = $instructor->courses
                        ->pluck('category.name')
                        ->filter()
                        ->unique()
                        ->values()
                        ->take(3)
                        ->all();

                    $imageExists =
                        $instructor->image &&
                        \Illuminate\Support\Facades\Storage::disk('public')->exists($instructor->image);

                    return [
                        'image' => $imageExists
                            ? \Illuminate\Support\Facades\Storage::url($instructor->image)
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($instructor->name) .
                                '&background=random&size=256&font-size=0.40',
                        'name' => $instructor->name,
                        'company' => 'EduLearn',
                        'title' => $instructor->courses_count > 0 ? 'Expert Instructor' : 'Course Instructor',
                        'rating' => '4.9',
                        'students' => number_format($students),
                        'courses' => (string) $instructor->courses_count,
                        'skills' => $skills ?: ['Teaching'],
                    ];
                });
            @endphp

            @forelse ($mentors as $mentor)
                <x-mentor-card :image="$mentor['image']" :name="$mentor['name']" :company="$mentor['company']" :title="$mentor['title']" :rating="$mentor['rating']"
                    :students="$mentor['students']" :courses="$mentor['courses']" :skills="$mentor['skills']" />
            @empty
                <p class="text-gray-500 col-span-full text-center">No instructors available yet.</p>
            @endforelse
        </div>

        <div
            class="mt-16 rounded-3xl border p-10 text-center" style="border-color: #4fcd9840; background: linear-gradient(to right, #4fcd9815, #f0717515);">
            <h3 class="text-4xl font-bold">Want to become an instructor?</h3>
            <p class="text-gray-500 mt-3 mb-8">Share your expertise with thousands of eager learners worldwide</p>
            <a href="#"
                class="inline-block rounded-full px-10 py-4 text-lg font-semibold text-white shadow-lg transition-all" style="background-color: #4fcd98;" onmouseover="this.style.backgroundColor='#3ab876'" onmouseout="this.style.backgroundColor='#4fcd98'">Apply
                as Instructor</a>
        </div>
    </div>
</section>

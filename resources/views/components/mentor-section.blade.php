<section id="mentors" class="py-24 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold">World-Class Mentors</h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Get personalized guidance from industry leaders at top tech companies.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $mentors = [
                    [
                        'image' => 'https://randomuser.me/api/portraits/women/71.jpg',
                        'name' => 'Dr. Sarah Mitchell',
                        'company' => 'Google',
                        'title' => 'AI & Machine Learning Expert',
                        'rating' => '4.9',
                        'students' => '15K',
                        'courses' => '8',
                        'skills' => ['AI', 'Deep Learning', 'Python'],
                    ],
                    [
                        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
                        'name' => 'Marcus Johnson',
                        'company' => 'Meta',
                        'title' => 'Senior Full Stack Developer',
                        'rating' => '4.9',
                        'students' => '22K',
                        'courses' => '12',
                        'skills' => ['React', 'Node.js', 'AWS'],
                    ],
                    [
                        'image' => 'https://randomuser.me/api/portraits/women/65.jpg',
                        'name' => 'Emily Zhang',
                        'company' => 'Apple',
                        'title' => 'Product Design Lead',
                        'rating' => '5.0',
                        'students' => '19K',
                        'courses' => '10',
                        'skills' => ['UI/UX', 'Figma', 'Design Systems'],
                    ],
                ];
            @endphp

            @foreach ($mentors as $mentor)
                <x-mentor-card :image="$mentor['image']" :name="$mentor['name']" :company="$mentor['company']" :title="$mentor['title']" :rating="$mentor['rating']"
                    :students="$mentor['students']" :courses="$mentor['courses']" :skills="$mentor['skills']" />
            @endforeach
        </div>

        <div
            class="mt-16 rounded-3xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-pink-50 p-10 text-center">
            <h3 class="text-4xl font-bold">Want to become a mentor?</h3>
            <p class="text-gray-500 mt-3 mb-8">Share your expertise with thousands of eager learners worldwide</p>
            <a href="#"
                class="inline-block rounded-full bg-blue-600 px-10 py-4 text-lg font-semibold text-white shadow-lg hover:bg-blue-700">Apply
                as Mentor</a>
        </div>
    </div>
</section>

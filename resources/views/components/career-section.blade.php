<section id="career-paths" class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-10">

        <div class="text-center mb-16">

            <h2 class="text-5xl font-bold">
                Fast-Track Your Career
            </h2>

            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Structured learning paths designed by industry experts
                to help you land your dream job
            </p>

        </div>

        @php
            $learningPaths = \App\Models\LearningPath::with('courses')->get();
            $colors = [
                ['bg' => 'from-purple-600 to-indigo-600', 'border' => 'border-purple-100', 'icon' => '🎯'],
                ['bg' => 'from-cyan-600 to-teal-600', 'border' => 'border-cyan-100', 'icon' => '📊'],
                ['bg' => 'from-pink-500 to-rose-500', 'border' => 'border-pink-100', 'icon' => '💼'],
                ['bg' => 'from-amber-400 to-orange-500', 'border' => 'border-amber-100', 'icon' => '🎨'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($learningPaths as $index => $path)
                @php
                    $colorSet = $colors[$index % count($colors)];
                    $courseCount = $path->courses()->count();
                @endphp
                <div class="rounded-3xl overflow-hidden shadow-sm border {{ $colorSet['border'] }} bg-white hover:shadow-lg transition">
                    <div class="p-6 bg-gradient-to-br {{ $colorSet['bg'] }} text-white">
                        <p class="text-sm opacity-70">Beginner to Advanced</p>
                        <h3 class="text-2xl font-bold mt-2">{{ $path->name }}</h3>
                        <div class="flex gap-4 text-sm mt-4 opacity-90">
                            <span>⏱ {{ $courseCount }}+ courses</span>
                            <span>👥 5K+ students</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-500 text-sm">{{ $path->description ?? 'Learning Path' }}</p>
                        <h4 class="text-2xl font-bold text-indigo-500 mt-3">$95K+</h4>
                        <div class="space-y-3 mt-6">
                            @forelse ($path->courses()->limit(4)->get() as $course)
                                <div class="flex justify-between items-center bg-gray-50 rounded-full px-4 py-2">
                                    <span class="text-sm">{{ $course->title }}</span>
                                    <span class="text-gray-500 text-xs">{{ $course->materis()->count() }}+ lessons</span>
                                </div>
                            @empty
                                <p class="text-gray-400 text-sm">No courses yet</p>
                            @endforelse
                        </div>
                        {{-- <a href="{{ route('roadmap', ['path_id' => $path->id]) }}" class="w-full mt-6 bg-black text-white py-3 rounded-xl text-center block hover:bg-gray-800 transition font-semibold">View Path</a> --}}
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</section>

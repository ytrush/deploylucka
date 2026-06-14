@php
    // Debug: see what we received
    $debugCourses = $courses ?? collect();
    if ($debugCourses->isEmpty()) {
        $courses = \App\Models\Course::with(['category', 'instructor', 'materis'])
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
    }
@endphp

@if($courses->count() > 0)
<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-10">

        <div class="text-center mb-16">

            <span class="px-4 py-2 bg-indigo-100 text-indigo-500 rounded-full text-sm">
                {{ __('📚 Featured Courses') }}
            </span>

            <h2 class="text-5xl font-bold mt-6">
                {{ __('Explore Our Top Courses') }}
            </h2>

            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                {{ __('Discover high-quality courses taught by industry experts. Start learning today and advance your career with our comprehensive curriculum.') }}
            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($courses as $course)
                @php
                    $courseMateris = $course->materis->sortBy('order');
                    $firstMateri = $courseMateris->first();
                    $totalDuration = $courseMateris->sum('duration');
                    $hours = floor($totalDuration / 60);
                    $minutes = $totalDuration % 60;
                    $durationText = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

                    // Get video embed URL
                    $videoEmbed = null;
                    $videoId = null;
                    if($firstMateri && $firstMateri->video_url) {
                        if(preg_match('/(?:youtube\.com\/watch\?v=|youtube\.com\/shorts\/|youtube\.com\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $firstMateri->video_url, $matches)) {
                            $videoId = $matches[1];
                            $videoEmbed = 'https://www.youtube.com/embed/' . $videoId . '?enablejsapi=1';
                        } elseif(preg_match('/vimeo\.com\/(\d+)/', $firstMateri->video_url, $matches)) {
                            $videoEmbed = 'https://player.vimeo.com/video/' . $matches[1];
                        }
                    }
                @endphp

                <a href="{{ route('courses.show', $course) }}" class="bg-white rounded-2xl shadow-md overflow-hidden w-full hover:shadow-xl transition block">

                    <!-- Video Embed (Single Video) -->
                    <div class="relative">
                        @if($videoEmbed)
                            <div class="aspect-video">
                                <iframe class="w-full h-full" src="{{ $videoEmbed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @elseif($firstMateri)
                            <div class="h-48 bg-slate-200 flex items-center justify-center">
                                <span class="text-4xl">🎬</span>
                            </div>
                        @else
                            <div class="h-48 bg-slate-200 flex items-center justify-center">
                                <span class="text-4xl">🎬</span>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        @if($course->category)
                            <span class="absolute top-3 left-3 bg-white text-sm px-3 py-1 rounded-full shadow">
                                {{ $course->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5">

                        <!-- Title -->
                        <h3 class="font-semibold text-lg mb-3 hover:text-indigo-500 cursor-pointer line-clamp-2">
                            {{ $course->title }}
                        </h3>

                        <!-- Instructor -->
                        @if($course->instructor)
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ $course->instructor->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($course->instructor->name) . '&background=random' }}"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-sm font-medium">{{ $course->instructor->name }}</p>
                                    <p class="text-xs text-gray-500">Expert Instructor</p>
                                </div>
                            </div>
                        @endif

                        
                        <!-- Description -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                    </div>
                </a>
            @endforeach
        </div>

    </div>

</section>
@endif
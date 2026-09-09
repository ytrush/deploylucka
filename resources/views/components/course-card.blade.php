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

@if ($courses->count() > 0)
    <section class="py-24 bg-gradient-to-b from-white via-gray-50 to-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-4 font-semibold text-sm" style="background-color: #4fcd9820; color: #4fcd98;">
                    <i class="ti ti-books"></i> {{ __('Featured Courses') }}
                </div>

                <h2 class="text-5xl md:text-6xl font-bold mt-6 leading-tight">
                    {{ __('Explore Our Top Courses') }}
                </h2>

                <p class="text-gray-600 mt-6 max-w-2xl mx-auto text-lg">
                    {{ __('Discover high-quality courses taught by industry experts. Start learning today and advance your career with our comprehensive curriculum.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($courses as $course)
                    @php
                        $courseMateris = $course->materis->sortBy('order');
                        $firstMateri = $courseMateris->first();
                        $totalDuration = $courseMateris->sum('duration');
                        $hours = floor($totalDuration / 60);
                        $minutes = $totalDuration % 60;
                        $durationText = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

                        // Get video preview URL
                        $videoPreviewUrl = null;
                        $videoPreviewType = null;
                        if ($firstMateri && $firstMateri->video_url) {
                            $videoUrl = $firstMateri->video_url;
                            if (
                                preg_match(
                                    '/(?:youtube\.com\/watch\?v=|youtube\.com\/shorts\/|youtube\.com\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/',
                                    $videoUrl,
                                    $matches,
                                )
                            ) {
                                $videoPreviewUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?enablejsapi=1';
                                $videoPreviewType = 'iframe';
                            } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                                $videoPreviewUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                $videoPreviewType = 'iframe';
                            } elseif (str_ends_with($videoUrl, '.mp4') || str_contains($videoUrl, '.mp4?')) {
                                $videoPreviewUrl = $videoUrl;
                                $videoPreviewType = 'video';
                            }
                        }
                    @endphp

                    <a href="{{ route('courses.show', $course) }}" class="group">
                            <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 hover:border-[#4fcd98] h-full flex flex-col hover:-translate-y-1">

                            <!-- Course Image / Preview -->
                            <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 h-56">
                                @if ($videoPreviewType === 'iframe' && $videoPreviewUrl)
                                    <div class="aspect-video w-full h-full">
                                        <iframe class="w-full h-full" src="{{ $videoPreviewUrl }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>
                                @elseif($videoPreviewType === 'video' && $videoPreviewUrl)
                                    <div class="w-full h-full bg-slate-900">
                                        <video class="w-full h-full object-cover" controls preload="metadata">
                                            <source src="{{ $videoPreviewUrl }}" type="video/mp4">
                                        </video>
                                    </div>
                                @elseif($course->image)
                                    <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-blue-600 flex items-center justify-center">
                                        <i class="ti ti-film text-white text-6xl opacity-40"></i>
                                    </div>
                                @endif

                                <!-- Overlay Badges -->
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="bg-white/95 backdrop-blur-sm rounded-full w-16 h-16 flex items-center justify-center shadow-lg" style="color: #4fcd98;">
                                             <i class="ti ti-play text-3xl"></i>
                                         </div>
                                    </div>
                                </div>

                                <!-- Top Badges -->
                                <div class="absolute top-4 left-4 right-4 flex items-start justify-between">
                                    @if ($course->category)
                                        <span class="bg-white/95 backdrop-blur-sm text-gray-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                            {{ $course->category->name }}
                                        </span>
                                    @endif
                                    <div class="text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1" style="background-color: #4fcd98;">
                                         <i class="ti ti-book"></i> {{ $courseMateris->count() }}
                                     </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-1">
                                <!-- Title -->
                                <h3 class="font-bold text-lg mb-3 line-clamp-2 transition-colors" style="color: inherit;" onmouseover="this.style.color='#4fcd98'" onmouseout="this.style.color='inherit'">
                                    {{ $course->title }}
                                </h3>

                                <!-- Description -->
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">
                                    {{ Str::limit($course->description, 80) }}
                                </p>

                                <!-- Stats -->
                                <div class="flex items-center gap-4 mb-4 py-3 border-t border-b border-gray-100 text-xs text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <i class="ti ti-clock"></i> {{ $durationText }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="ti ti-users"></i> {{ $course->enrollments()->count() }} enrolled
                                    </span>
                                </div>

                                <!-- Instructor -->
                                @if ($course->instructor)
                                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background: linear-gradient(135deg, #4fcd98 0%, #3ab876 100%);">
                                             {{ substr($course->instructor->name, 0, 1) }}
                                         </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $course->instructor->name }}</p>
                                            <p class="text-xs text-gray-500">Instructor</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- CTA Button -->
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="inline-flex items-center gap-2 font-bold text-sm group-hover:gap-3 transition-all" style="color: #4fcd98;">
                                         View Course <i class="ti ti-arrow-right"></i>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- View All Courses CTA -->
            <div class="text-center mt-16">
                <a href="{{ route('courses.index') }}" 
                    class="inline-flex items-center gap-2 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5" style="background-color: #4fcd98;" onmouseover="this.style.backgroundColor='#3ab876'" onmouseout="this.style.backgroundColor='#4fcd98'">
                    <i class="ti ti-search"></i> View All Courses
                </a>
            </div>

        </div>

    </section>
@endif

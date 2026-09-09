<x-app-layout>
    <div class="bg-gradient-to-br from-green-50 via-indigo-50 to-white min-h-screen overflow-x-hidden">

        <!-- Success Alert -->
        @if (session('success'))
            <div class="fixed top-4 right-4 z-50 max-w-md">
                <div class="rounded-lg bg-gradient-to-r from-green-500 to-emerald-500 border border-green-400 p-4 text-white flex items-start gap-3 shadow-lg animate-slideIn">
                    <i class="ti ti-check-circle text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-white">Success!</p>
                        <p class="text-sm text-green-50">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-green-100 hover:text-white transition-colors">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            </div>
            <style>
                @keyframes slideIn {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                .animate-slideIn {
                    animation: slideIn 0.3s ease-out;
                }
            </style>
        @endif

        <!-- Info Alert -->
        @if (session('info'))
            <div class="fixed top-4 right-4 z-50 max-w-md">
                <div class="rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500 border border-blue-400 p-4 text-white flex items-start gap-3 shadow-lg animate-slideIn">
                    <i class="ti ti-info-circle text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-white">Info</p>
                        <p class="text-sm text-blue-50">{{ session('info') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-blue-100 hover:text-white transition-colors">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            </div>
            <style>
                @keyframes slideIn {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                .animate-slideIn {
                    animation: slideIn 0.3s ease-out;
                }
            </style>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="fixed top-4 right-4 z-50 max-w-md">
                <div class="rounded-lg bg-gradient-to-r from-red-500 to-rose-500 border border-red-400 p-4 text-white flex items-start gap-3 shadow-lg animate-slideIn">
                    <i class="ti ti-alert-circle text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-white">Error!</p>
                        <p class="text-sm text-red-50">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-100 hover:text-white transition-colors">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        <style>
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            .animate-slideIn {
                animation: slideIn 0.3s ease-out;
            }
        </style>

        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600">
            <!-- Animated Background Elements (subtle) -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-32 md:pt-28 md:pb-22">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <!-- Left Content -->
                    <div class="text-white space-y-6">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white rounded-full px-4 py-2 font-semibold text-sm border border-white/30 w-fit">
                            <i class="ti ti-sparkles"></i> Unlock Your Potential
                        </div>

                        <!-- Main Heading -->
                        <div>
                            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-4 text-white">
                                Master New <span class="text-green-200">Skills</span> Today
                            </h1>
                            <p class="text-lg md:text-xl text-green-100 leading-relaxed max-w-xl">
                                Join thousands of learners exploring world-class courses taught by industry experts. Achieve your goals with our comprehensive learning platform.
                            </p>
                        </div>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-8 pt-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="ti ti-book text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-100">Total Courses</p>
                                    <p class="text-2xl font-bold text-white">{{ $courses->total() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="ti ti-users text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-100">Active Learners</p>
                                    <p class="text-2xl font-bold text-white">50K+</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="ti ti-certificate text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-100">Certificates</p>
                                    <p class="text-2xl font-bold text-white">10K+</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="#all-courses"
                                class="inline-flex items-center gap-2 bg-white text-green-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all duration-300 hover:shadow-2xl hover:-translate-y-0.5 shadow-lg">
                                <i class="ti ti-play"></i> Start Learning
                            </a>
                            <a href="#learning-paths"
                                class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 px-8 py-4 rounded-xl font-bold hover:bg-white/30 transition-all duration-300">
                                <i class="ti ti-route"></i> Explore Paths
                            </a>
                        </div>
                    </div>

                    <!-- Right Image/Illustration -->
                    <div class="hidden lg:flex items-center justify-center">
                        <div class="relative w-full max-w-md">
                            <!-- Floating cards animation - Dynamic from courses data -->
                            @php
                                $topCourses = $courses->items();
                                $course1 = $topCourses[0] ?? null;
                                $course2 = $topCourses[1] ?? null;
                                $course3 = $topCourses[2] ?? null;
                            @endphp
                            
                            @if($course1)
                            <div class="absolute top-0 right-0 w-32 h-40 bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30 transform rotate-6 animate-float">
                                @if($course1->image)
                                    <img src="{{ asset('storage/' . $course1->image) }}" alt="{{ $course1->title }}" class="w-full h-20 rounded-lg mb-3 object-cover">
                                @else
                                    <div class="w-full h-20 bg-gradient-to-br from-green-200 to-green-300 rounded-lg mb-3"></div>
                                @endif
                                <p class="text-white text-xs font-semibold line-clamp-2">{{ $course1->title }}</p>
                                <p class="text-green-100 text-xs mt-1">{{ $course1->materis()->count() }} Lessons</p>
                            </div>
                            @endif
                            
                            @if($course2)
                            <div class="absolute bottom-10 left-0 w-32 h-40 bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30 transform -rotate-6 animate-float animation-delay-1000">
                                @if($course2->image)
                                    <img src="{{ asset('storage/' . $course2->image) }}" alt="{{ $course2->title }}" class="w-full h-20 rounded-lg mb-3 object-cover">
                                @else
                                    <div class="w-full h-20 bg-gradient-to-br from-emerald-200 to-emerald-300 rounded-lg mb-3"></div>
                                @endif
                                <p class="text-white text-xs font-semibold line-clamp-2">{{ $course2->title }}</p>
                                <p class="text-green-100 text-xs mt-1">{{ $course2->materis()->count() }} Lessons</p>
                            </div>
                            @endif
                            
                            @if($course3)
                            <div class="w-80 h-80 bg-white/15 backdrop-blur-sm rounded-3xl border border-white/20 flex flex-col items-center justify-center p-4">
                                @if($course3->image)
                                    <img src="{{ asset('storage/' . $course3->image) }}" alt="{{ $course3->title }}" class="w-full h-56 rounded-2xl mb-4 object-cover">
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-blue-200 to-blue-300 rounded-2xl mb-4"></div>
                                @endif
                                <p class="text-white text-sm font-semibold text-center line-clamp-2">{{ $course3->title }}</p>
                                <p class="text-green-100 text-xs mt-2 text-center">{{ $course3->materis()->count() }} Lessons</p>
                            </div>
                            @else
                            <div class="w-80 h-80 bg-white/15 backdrop-blur-sm rounded-3xl border border-white/20 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="ti ti-book-2 text-white text-8xl opacity-20 mb-4"></i>
                                    <p class="text-white text-sm font-semibold">{{ $courses->total() }} Courses</p>
                                    <p class="text-green-100 text-xs mt-1">Available to explore</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @keyframes blob {
                    0%, 100% { transform: translate(0, 0) scale(1); }
                    33% { transform: translate(30px, -50px) scale(1.1); }
                    66% { transform: translate(-20px, 20px) scale(0.9); }
                }
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotate(6deg); }
                    50% { transform: translateY(-20px) rotate(6deg); }
                }
                .animate-blob {
                    animation: blob 7s infinite;
                }
                .animate-float {
                    animation: float 3s ease-in-out infinite;
                }
                .animation-delay-1000 {
                    animation-delay: 1s;
                }
                .animation-delay-2000 {
                    animation-delay: 2s;
                }
                .animation-delay-4000 {
                    animation-delay: 4s;
                }
            </style>
        </section>

        <!-- Learning Paths Section -->
         @if ($learningPaths->isNotEmpty())
             <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                 <div class="mb-6 flex items-center justify-between">
                     <div>
                         <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                             <i class="ti ti-route"></i> Learning Paths
                         </h2>
                         <p class="text-gray-600 text-sm mt-1">Structured journeys to master your skills</p>
                     </div>
                      <div class="flex items-center gap-2">
                          <button id="learningPathsPrevBtn" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white border border-green-600 transition-all text-sm font-medium">
                              <i class="ti ti-chevron-left"></i>
                              <span>Previous</span>
                          </button>
                          <button id="learningPathsNextBtn" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white border border-green-600 transition-all text-sm font-medium">
                              <span>Next</span>
                              <i class="ti ti-chevron-right"></i>
                          </button>
                      </div>
                 </div>

                 <div class="swiper learningPathsSwiper">
                     <div class="swiper-wrapper">
                         @foreach ($learningPaths as $path)
                             @php
                                 $isActivePath = ($selectedPathId ?? false) == $path->id;
                             @endphp
                             <div class="swiper-slide">
                                 <a href="{{ route('courses.index', array_filter(['category_id' => $selectedCategoryId ?? null, 'path_id' => $path->id])) }}" class="group h-full">
                                     <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border-2 {{ $isActivePath ? 'border-green-500 ring-2 ring-green-200' : 'border-green-200 hover:border-green-400' }} hover:-translate-y-1 h-full flex flex-col p-6">
                                         <!-- Header Icon -->
                                         <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-xl mb-4">
                                             <i class="ti ti-map"></i>
                                         </div>

                                         <!-- Content -->
                                         <h3 class="text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition-colors mb-2">
                                             {{ $path->name }}
                                         </h3>
                                         <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">
                                             {{ $path->description }}
                                         </p>

                                         <!-- Course Count -->
                                         <div class="flex items-center gap-2 mb-4 pt-4 border-t border-green-200">
                                             <i class="ti ti-book text-green-600"></i>
                                             <span class="text-sm font-semibold text-gray-900">
                                                 {{ $path->courses->count() }} {{ $path->courses->count() === 1 ? 'course' : 'courses' }}
                                             </span>
                                         </div>

                                         <!-- CTA -->
                                         <div class="inline-flex items-center gap-2 text-green-600 font-bold text-sm group-hover:gap-3 transition-all">
                                             <span>{{ $isActivePath ? 'Showing all' : 'Explore Path' }}</span>
                                             <i class="ti ti-arrow-right"></i>
                                         </div>
                                     </div>
                                 </a>
                             </div>
                         @endforeach
                     </div>
                 </div>

                 <script>
                     document.addEventListener('DOMContentLoaded', function() {
                         const swiper = new Swiper('.learningPathsSwiper', {
                             slidesPerView: 1,
                             spaceBetween: 24,
                             navigation: {
                                 nextEl: '#learningPathsNextBtn',
                                 prevEl: '#learningPathsPrevBtn',
                             },
                             breakpoints: {
                                 640: {
                                     slidesPerView: 2,
                                     spaceBetween: 24,
                                 },
                                 1024: {
                                     slidesPerView: 3,
                                     spaceBetween: 24,
                                 },
                             },
                         });
                     });
                 </script>
             </section>
         @endif

        <!-- Recent Courses Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @php
                $recentCourses = Auth::check()
                    ? Auth::user()->enrolledCourses()->latest('enrollments.created_at')->get()
                        ->filter(function ($course) use ($courseProgress) {
                            $progress = $courseProgress[$course->id] ?? ['percentage' => 0];
                            return $progress['percentage'] < 100; // Hanya courses yang belum 100%
                        })
                        ->take(3) // Maksimal 3 courses
                    : collect();
            @endphp

            @if ($recentCourses->isNotEmpty())
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="ti ti-player-play"></i> Continue Learning
                            </h2>
                            <p class="text-gray-600 text-xs mt-1">Pick up where you left off</p>
                        </div>
                        <a href="#all-courses" class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-700 font-semibold text-sm hover:gap-2 transition-all">
                            View All <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($recentCourses as $course)
                            @php
                                $progress = $courseProgress[$course->id] ?? [
                                    'percentage' => 0,
                                    'completed' => 0,
                                    'total' => 0,
                                ];
                                $isCompleted = $progress['percentage'] >= 100;
                            @endphp

                            <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-green-400 flex flex-col h-full hover:-translate-y-1">
                                <!-- Image -->
                                <a href="{{ route('courses.show', $course) }}" class="relative h-40 overflow-hidden bg-gradient-to-br from-green-400 to-emerald-500 block">
                                    @if ($course->image)
                                        <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-400 to-emerald-500">
                                            <i class="ti ti-book-2 text-white text-3xl opacity-30"></i>
                                        </div>
                                    @endif

                                    <!-- Status Badge -->
                                    <div class="absolute top-2 right-2">
                                        @if ($isCompleted)
                                            <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-0.5 shadow-md">
                                                <i class="ti ti-check text-sm"></i> Done
                                            </span>
                                        @else
                                            <span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow-md">
                                                {{ $progress['percentage'] }}%
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Category Tag -->
                                    <div class="absolute top-2 left-2">
                                        <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                            {{ $course->category->name ?? 'Course' }}
                                        </span>
                                    </div>
                                </a>

                                <!-- Content -->
                                <div class="p-3 flex flex-col flex-1">
                                    <!-- Title -->
                                    <a href="{{ route('courses.show', $course) }}" class="block mb-2">
                                        <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition-colors text-sm">
                                            {{ $course->title }}
                                        </h3>
                                    </a>

                                    <!-- Progress -->
                                    <div class="mb-2">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-medium text-gray-600">Progress</span>
                                            <span class="text-xs font-bold text-green-600">{{ $progress['percentage'] }}%</span>
                                        </div>
                                        <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-green-400 to-green-500 transition-all duration-500"
                                                style="width: {{ $progress['percentage'] }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $progress['completed'] }}/{{ $progress['total'] }} lessons</p>
                                    </div>

                                    <!-- Instructor -->
                                    <div class="flex items-center gap-1.5 mb-2">
                                        @if ($course->instructor)
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                {{ substr($course->instructor->name, 0, 1) }}
                                            </div>
                                            <p class="text-xs font-medium text-gray-700 truncate">{{ $course->instructor->name }}</p>
                                        @endif
                                    </div>

                                    <!-- Continue Button -->
                                    <a href="{{ route('courses.show', $course) }}" class="mt-auto inline-flex items-center justify-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg font-semibold text-xs transition-all duration-300 shadow-sm hover:shadow-md w-full">
                                        <i class="ti ti-play"></i>
                                        <span>Continue</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <!-- Categories Section -->
        <section class="bg-gradient-to-br from-green-50 via-white to-indigo-50 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-7">
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <i class="ti ti-tag text-white text-lg"></i>
                        </div>
                        Explore by Category
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Discover courses in your favorite categories</p>
                </div>

                <!-- Grid Container -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($categories as $category)
                        @php
                            $topCourse = $category->courses()->with('instructor')->first();
                        @endphp
                        <a href="{{ route('courses.index', ['category_id' => $category->id]) }}"
                            class="group cursor-pointer">
                            <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 hover:border-green-400 shadow-sm hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1 h-full flex flex-col">
                                <!-- Image with Padding -->
                                <div class="p-4 pb-0">
                                    <div class="relative h-64 rounded-xl overflow-hidden">
                                        @if ($category->image)
                                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600 flex items-center justify-center">
                                                <i class="ti ti-tag text-white text-5xl opacity-30"></i>
                                            </div>
                                        @endif
                                        <!-- Course Count Badge -->
                                        <div class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                            {{ $category->courses_count }} course{{ $category->courses_count !== 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Content Below -->
                                <div class="px-5 pt-4 pb-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition-colors text-lg">{{ $category->name }}</h3>
                                        <!-- Course Details -->
                                        <div class="mt-2.5 space-y-1.5">
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <i class="ti ti-book text-green-500"></i>
                                                <span>{{ $category->courses_count }} course{{ $category->courses_count !== 1 ? 's' : '' }} available</span>
                                            </div>
                                            @if ($topCourse)
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <i class="ti ti-users text-blue-500"></i>
                                                    <span>{{ $topCourse->enrollments()->count() }} enrolled</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <i class="ti ti-book-2 text-purple-500"></i>
                                                    <span>{{ $topCourse->materis()->count() }} lessons in latest</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-4 pt-3 border-t border-gray-100">
                                        <i class="ti ti-arrow-right text-green-500 text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                                        <span class="text-green-600 text-xs font-semibold group-hover:underline">Browse courses</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- All Courses Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" id="all-courses" style="scroll-margin-top: 140px;">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="ti ti-book"></i> All Courses
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ $courses->total() }} courses available</p>
            </div>

            <!-- Filter Section -->
            <div class="mb-8">
                <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col sm:flex-row gap-2 items-end">
                    <!-- Search Bar -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-search text-gray-400 text-sm"></i>
                        </div>
                        <input id="search" name="search" type="text" value="{{ $search ?? '' }}"
                            placeholder="Search courses..."
                            class="w-full rounded-lg border border-gray-200 hover:border-green-300 focus:border-green-500 bg-white px-3 py-2 pl-9 focus:outline-none focus:ring-0 transition-all duration-300 text-gray-900 placeholder-gray-500 text-sm" />
                    </div>

                    <!-- Category Filter -->
                    <div class="relative w-full sm:w-48">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-tag text-gray-400 text-sm"></i>
                        </div>
                        <select id="category_id" name="category_id"
                            class="w-full rounded-lg border border-gray-200 hover:border-green-300 focus:border-green-500 bg-white px-3 py-2 pl-9 focus:outline-none focus:ring-0 transition-all duration-300 text-gray-900 appearance-none cursor-pointer text-sm">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(($selectedCategoryId ?? false) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="ti ti-chevron-down text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 hover:shadow-md text-sm">
                            <i class="ti ti-search text-sm"></i>
                            <span>Search</span>
                        </button>
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center justify-center gap-1 border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 hover:text-gray-900 font-semibold py-2 px-4 rounded-lg transition-all duration-300 text-sm">
                            <i class="ti ti-refresh text-sm"></i>
                            <span class="hidden sm:inline">Reset</span>
                        </a>
                    </div>
                </form>

                    <!-- Active Filters Display -->
                    @if ($search || ($selectedCategoryId ?? false) || ($selectedPathId ?? false))
                        <div class="flex flex-wrap items-center gap-2 pt-2">
                            <span class="text-sm text-gray-600 font-medium">Active filters:</span>
                            @if ($search)
                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-medium">
                                    <i class="ti ti-search"></i>
                                    {{ $search }}
                                    <a href="{{ route('courses.index', array_filter(['category_id' => $selectedCategoryId ?? null, 'path_id' => $selectedPathId ?? null])) }}" class="ml-1 hover:text-green-900">
                                        <i class="ti ti-x"></i>
                                    </a>
                                </span>
                            @endif
                            @if ($selectedCategoryId ?? false)
                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-medium">
                                    <i class="ti ti-tag"></i>
                                    {{ $categories->find($selectedCategoryId)?->name }}
                                    <a href="{{ route('courses.index', array_filter(['search' => $search ?? null, 'path_id' => $selectedPathId ?? null])) }}" class="ml-1 hover:text-green-900">
                                        <i class="ti ti-x"></i>
                                    </a>
                                </span>
                            @endif
                            @if ($selectedPathId ?? false)
                                @php
                                    $activePath = $learningPaths->firstWhere('id', $selectedPathId);
                                @endphp
                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-medium">
                                    <i class="ti ti-route"></i>
                                    {{ $activePath?->name ?? 'Learning Path' }}
                                    <a href="{{ route('courses.index', array_filter(['search' => $search ?? null, 'category_id' => $selectedCategoryId ?? null])) }}" class="ml-1 hover:text-green-900">
                                        <i class="ti ti-x"></i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    @endif
                </form>
            </div>

            <script>
                (function () {
                    if (!window.location.search) return;
                    if ('scrollRestoration' in history) {
                        history.scrollRestoration = 'manual';
                    }
                    function scrollToCourses() {
                        var el = document.getElementById('all-courses');
                        if (!el) return;
                        requestAnimationFrame(function () {
                            requestAnimationFrame(function () {
                                var topPos = el.getBoundingClientRect().top + window.scrollY - 1;
                                window.scrollTo({ top: topPos, behavior: 'smooth' });
                            });
                        });
                    }
                    if (document.readyState === 'complete') {
                        scrollToCourses();
                    } else {
                        window.addEventListener('load', scrollToCourses);
                    }
                })();
            </script>

            <!-- Courses Grid -->
            @if ($courses->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        @php
                            $progress = $courseProgress[$course->id] ?? ['percentage' => 0, 'completed' => 0, 'total' => 0];
                            $isCompleted = $progress['percentage'] >= 100;
                            $isEnrolled = Auth::check() && $course->isEnrolledBy(Auth::user());
                        @endphp

                        <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-green-400 flex flex-col h-full hover:-translate-y-1">
                        <!-- Image -->
                        <a href="{{ route('courses.show', $course) }}" class="relative h-40 overflow-hidden bg-gradient-to-br from-green-400 to-emerald-500 block">
                        @if ($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-400 to-emerald-500">
                                <i class="ti ti-book-2 text-white text-3xl opacity-30"></i>
                            </div>
                        @endif

                        <!-- Top Badges -->
                        <div class="absolute top-2 left-2 right-2 flex items-start justify-between gap-1">
                            <span class="inline-flex items-center gap-0.5 bg-white/90 backdrop-blur-sm text-gray-700 rounded-full px-2 py-0.5 text-xs font-semibold">
                                <i class="ti ti-book text-sm"></i> {{ $course->materis->count() }}
                            </span>
                            @if ($isCompleted)
                                <div class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-0.5 shadow-md">
                                    <i class="ti ti-check text-sm"></i> Done
                                </div>
                            @elseif ($isEnrolled && $progress['percentage'] > 0)
                                <div class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow-md">
                                    {{ $progress['percentage'] }}%
                                </div>
                            @endif
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute bottom-2 left-2">
                            <span class="bg-green-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                {{ $course->category->name ?? 'Course' }}
                            </span>
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="p-4 flex flex-col flex-1">
                        <!-- Title -->
                        <a href="{{ route('courses.show', $course) }}" class="block mb-2">
                            <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition-colors text-sm">
                                {{ $course->title }}
                            </h3>
                        </a>

                        <!-- Progress Bar (if enrolled) -->
                        @if ($isEnrolled)
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-green-600">{{ $progress['percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-green-500 transition-all duration-500"
                                        style="width: {{ $progress['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Instructor -->
                        <div class="flex items-center gap-2 mb-3">
                            @if ($course->instructor)
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ substr($course->instructor->name, 0, 1) }}
                                </div>
                                <p class="text-xs font-medium text-gray-700 truncate">{{ $course->instructor->name }}</p>
                            @endif
                        </div>

                        <!-- Duration -->
                        <div class="flex items-center gap-1.5 text-xs text-gray-600 mb-3">
                            <i class="ti ti-clock"></i>
                            <span>{{ $course->materis->sum('duration') ?? 0 }} mins</span>
                        </div>

                        <!-- Enrollment Action -->
                        <div class="mt-auto">
                            @auth
                                @if ($isEnrolled)
                                    <form action="{{ route('courses.disenroll', $course) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 px-3 py-2 rounded-lg font-semibold text-xs transition-all duration-300 border border-red-200 hover:border-red-300">
                                            <i class="ti ti-trash"></i>
                                            <span>Disenroll</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-3 py-2 rounded-lg font-semibold text-xs transition-all duration-300 shadow-sm hover:shadow-md">
                                            <i class="ti ti-download"></i>
                                            <span>Enroll</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-3 py-2 rounded-lg font-semibold text-xs transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="ti ti-login"></i>
                                    <span>Sign In</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 col-span-full">
                    <i class="ti ti-inbox text-gray-300 text-6xl block mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium mb-2">No courses available yet</p>
                    <p class="text-gray-500 text-sm mb-6">Check back soon or explore other categories</p>
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold hover:gap-3 transition-all">
                        <i class="ti ti-arrow-left"></i> Browse all courses
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if ($courses->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
                        {{ $courses->links() }}
                    </div>
                </div>
            @endif
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-green-600 via-emerald-500 to-teal-500 text-white py-16 mt-12">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white rounded-full px-4 py-2 mb-4 font-medium text-sm">
                    <i class="ti ti-sparkles"></i> Start Your Learning Journey
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Ready to upskill?</h2>
                <p class="text-green-100 mb-8 max-w-2xl mx-auto text-lg leading-relaxed">Join thousands of students mastering new skills on our platform. Get instant access to all courses, certificates, and community support.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#all-courses"
                        class="inline-flex items-center gap-2 bg-white text-green-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Explore Courses
                        <i class="ti ti-arrow-right"></i>
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 transition-all duration-300">
                        Sign In
                        <i class="ti ti-login"></i>
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>

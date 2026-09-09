<x-app-layout>
    <!-- Hero Section - Timeline/Journey Design -->
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-400 via-green-400 to-teal-400 pt-24 pb-20">
        <!-- Animated Background Elements -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center mb-16">
                <!-- Left Column - Text Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Top Badge -->
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-full px-4 py-2 font-semibold text-sm w-fit">
                        <i class="ti ti-target"></i> Your Progress Tracker
                    </div>

                    <!-- Main Heading -->
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white leading-tight">
                            Track Your
                            <br />
                            <span class="bg-gradient-to-r from-white via-green-100 to-emerald-100 bg-clip-text text-transparent">Learning Journey</span>
                        </h1>
                        <p class="text-lg text-white/80 max-w-xl leading-relaxed">
                            Monitor your progress across structured learning paths. Discover milestones, celebrate achievements, and plan your next steps with confidence.
                        </p>
                    </div>

                    <!-- Progress Pills -->
                    <div class="flex flex-wrap gap-3">
                         <div class="group cursor-pointer">
                             <div class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all">
                                 <div class="flex items-center gap-2 text-white">
                                     <i class="ti ti-book text-lg"></i>
                                     <span class="font-semibold">{{ $courseRoadmap->count() }} Courses</span>
                                 </div>
                             </div>
                         </div>
                         <div class="group cursor-pointer">
                             <div class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all">
                                 <div class="flex items-center gap-2 text-white">
                                     <i class="ti ti-flame text-lg"></i>
                                     <span class="font-semibold">{{ $courseRoadmap->where('progress', '>', 0)->where('progress', '<', 100)->count() }} In Progress</span>
                                 </div>
                             </div>
                         </div>
                        <div class="group cursor-pointer">
                            <div class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all">
                                <div class="flex items-center gap-2 text-white">
                                    <i class="ti ti-check text-lg"></i>
                                    <span class="font-semibold">{{ $courseRoadmap->where('progress', '>=', 100)->count() }} Completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Visual Stats -->
                <div class="flex items-center justify-center">
                    <div class="relative w-full max-w-xs">
                        <!-- Central Circle -->
                        <div class="w-64 h-64 mx-auto relative">
                         <!-- Outer Ring -->
                             <div class="absolute inset-0 rounded-full border-2 border-white/20"></div>
                             <div class="absolute inset-2 rounded-full border border-white/30"></div>

                            <!-- Progress Ring -->
                            <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 260 260">
                                 <circle cx="130" cy="130" r="120" fill="none" stroke="rgba(255, 255, 255, 0.2)" stroke-width="8"/>
                                <circle cx="130" cy="130" r="120" fill="none" stroke="url(#progressGradient)" stroke-width="8"
                                    stroke-dasharray="376.99" stroke-dashoffset="0" stroke-linecap="round"
                                    style="stroke-dashoffset: {{ 376.99 * (1 - ($courseRoadmap->where('progress', '>=', 100)->count() / max(1, $courseRoadmap->count()))) }};"
                                />
                                 <defs>
                                      <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                         <stop offset="0%" stop-color="#ffffff"/>
                                         <stop offset="100%" stop-color="#d1fae5"/>
                                     </linearGradient>
                                 </defs>
                            </svg>

                            <!-- Center Content -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="text-center">
                                    <p class="text-white/70 text-sm mb-1">Overall Progress</p>
                                    <p class="text-5xl font-black bg-gradient-to-r from-white to-green-100 bg-clip-text text-transparent">
                                         {{ $courseRoadmap->count() > 0 ? round(($courseRoadmap->where('progress', '>=', 100)->count() / $courseRoadmap->count()) * 100) : 0 }}%
                                     </p>
                                </div>
                            </div>
                        </div>

                         <!-- Decorative Elements -->
                         <div class="absolute -top-4 -right-4 w-12 h-12 bg-white/10 rounded-full blur-xl"></div>
                         <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-white/10 rounded-full blur-xl"></div>
                    </div>
                </div>
            </div>

            <!-- Timeline Navigation -->
            <div class="grid grid-cols-3 md:grid-cols-5 gap-2 md:gap-4 mb-12">
                @php
                    $stages = [
                        ['icon' => 'ti-flag-off', 'label' => 'Start', 'color' => 'gray'],
                        ['icon' => 'ti-progress-check', 'label' => 'Learning', 'color' => 'blue'],
                        ['icon' => 'ti-building', 'label' => 'Building', 'color' => 'purple'],
                        ['icon' => 'ti-star', 'label' => 'Mastery', 'color' => 'orange'],
                        ['icon' => 'ti-crown', 'label' => 'Expert', 'color' => 'green'],
                    ];
                @endphp
                @foreach ($stages as $index => $stage)
                    <div class="group cursor-pointer">
                        <div class="relative">
                            <div class="p-4 rounded-xl border-2 {{ $index <= 2 ? 'border-white/40 bg-white/20' : 'border-white/20 bg-white/10' }} group-hover:border-white/60 transition-all">
                                <i class="ti {{ $stage['icon'] }} text-2xl {{ $index <= 2 ? 'text-white' : 'text-white/50' }}"></i>
                            </div>
                            <p class="text-center text-xs font-semibold text-white/60 mt-2 group-hover:text-white transition-colors">
                                {{ $stage['label'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#learning-paths"
                    class="inline-flex items-center justify-center gap-2 bg-white text-emerald-700 px-8 py-4 rounded-lg font-bold transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 shadow-lg">
                    <i class="ti ti-route"></i> View Your Path
                </a>
                <a href="{{ route('courses.index') }}"
                    class="inline-flex items-center justify-center gap-2 border-2 border-white/40 text-white px-8 py-4 rounded-lg font-bold hover:bg-white/10 transition-all duration-300">
                    <i class="ti ti-book"></i> Explore Courses
                </a>
            </div>
        </div>

        <!-- Bottom Accent Line -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

        <style>
            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
            }
            .animate-blob { animation: blob 7s infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }
        </style>
    </section>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Learning Paths Section -->
            @if ($pathSummaries->isNotEmpty())
                <section id="learning-paths">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ti ti-route"></i> Learning Paths
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">Structured learning journeys designed for you</p>
                    </div>

                    <div class="grid gap-8">
                        @foreach ($pathSummaries as $summary)
                            <div class="rounded-2xl bg-white p-8 shadow-md hover:shadow-xl transition-shadow border border-gray-200">
                                <!-- Header -->
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
                                    <div>
                                         <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full font-semibold text-sm mb-3">
                                             <i class="ti ti-bookmark"></i> Learning Path
                                         </div>
                                        <h3 class="text-3xl font-bold text-gray-900">{{ $summary->path->name }}</h3>
                                        <p class="text-gray-600 mt-2 max-w-2xl">{{ $summary->path->description }}</p>
                                    </div>
                                     <div class="text-center lg:text-right bg-gradient-to-br from-green-50 to-emerald-100 p-6 rounded-2xl border border-green-200">
                                         <p class="text-5xl font-bold text-green-600">{{ $summary->progress }}%</p>
                                         <p class="text-sm text-gray-600 mt-2">Overall Progress</p>
                                     </div>
                                </div>

                                 <!-- Progress Bar -->
                                 <div class="mb-8">
                                     <div class="h-3 bg-gray-200 rounded-full overflow-hidden shadow-sm">
                                         <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 transition-all duration-500 rounded-full" 
                                             style="width: {{ $summary->progress }}%"></div>
                                     </div>
                                 </div>

                                <!-- Courses in Path -->
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <i class="ti ti-list-check"></i> Courses in This Path
                                    </h4>
                                    <div class="grid gap-4">
                                        @foreach ($summary->courses as $index => $item)
                                            <div class="rounded-xl border-2 border-gray-200 hover:border-green-300 bg-gradient-to-r from-gray-50 to-white p-6 transition-all hover:shadow-md">
                                                <div class="flex items-start justify-between gap-4">
                                                    <!-- Course Info -->
                                                    <div class="flex-1 min-w-0">
                                                         <div class="flex items-center gap-3 mb-2">
                                                             <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm">
                                                                 {{ $index + 1 }}
                                                             </div>
                                                             <span class="text-xs font-bold text-green-600 uppercase tracking-wide">{{ $item->course->category?->name ?? 'Course' }}</span>
                                                         </div>
                                                        <h5 class="text-lg font-bold text-gray-900">{{ $item->course->title }}</h5>
                                                        <p class="text-sm text-gray-600 mt-2 flex items-center gap-1">
                                                            <i class="ti ti-user"></i> {{ $item->course->instructor?->name ?? 'Tutor' }}
                                                        </p>
                                                    </div>
                                                    
                                                     <!-- Progress Info -->
                                                     <div class="text-right flex-shrink-0">
                                                         <p class="text-3xl font-bold text-green-600">{{ $item->progress }}%</p>
                                                         <p class="text-xs text-gray-500 mt-1">{{ $item->remaining }} lessons left</p>
                                                     </div>
                                                </div>
                                                
                                                <!-- Progress Bar -->
                                                <div class="mt-4">
                                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 transition-all duration-500" 
                                                            style="width: {{ $item->progress }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <!-- No Learning Paths - Show Enrolled Courses and Recommendations -->
                <section class="grid gap-8 lg:grid-cols-2">
                    <!-- Enrolled Courses -->
                    <div>
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="ti ti-book"></i> Your Courses
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Courses you're currently learning</p>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                            <div class="space-y-4">
                                @forelse ($courseRoadmap as $item)
                                    <div class="rounded-xl border-2 border-gray-200 hover:border-green-300 bg-gradient-to-r from-green-50 to-white p-5 transition-all hover:shadow-md cursor-pointer">
                                         <div class="flex items-start justify-between gap-3">
                                             <div class="flex-1 min-w-0">
                                                 <span class="text-xs font-bold text-green-600 uppercase tracking-wide">{{ $item->course->category?->name ?? 'Course' }}</span>
                                                 <h5 class="text-lg font-bold text-gray-900 mt-1">{{ $item->course->title }}</h5>
                                                 <p class="text-sm text-gray-600 mt-2">
                                                     <i class="ti ti-user"></i> {{ $item->course->instructor?->name ?? 'Tutor' }}
                                                 </p>
                                             </div>
                                             <div class="text-right flex-shrink-0">
                                                 <p class="text-2xl font-bold text-green-600">{{ $item->progress }}%</p>
                                                 <span class="text-xs text-gray-500">{{ $item->remaining }} left</span>
                                             </div>
                                         </div>
                                        
                                        <div class="mt-3">
                                             <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                 <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 transition-all" 
                                                     style="width: {{ $item->progress }}%"></div>
                                             </div>
                                         </div>
                                        
                                        <div class="mt-3 text-xs text-gray-500">
                                            {{ $item->completed }} / {{ $item->total }} lessons completed
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-xl border-2 border-dashed border-gray-300 p-8 text-center">
                                        <i class="ti ti-inbox text-gray-300 text-4xl block mb-3"></i>
                                        <p class="text-gray-600 font-medium">No enrolled courses yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Visit the Courses page to start learning</p>
                                         <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 text-green-600 font-bold mt-4 hover:gap-3 transition-all">
                                             <i class="ti ti-arrow-right"></i> Browse Courses
                                         </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Courses -->
                    <div>
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="ti ti-lightbulb"></i> Recommendations
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Personalized courses for you</p>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                            <div class="space-y-4">
                                @forelse ($recommendedCourses as $course)
                                    <a href="{{ route('courses.show', $course) }}" class="group">
                                         <div class="rounded-xl border-2 border-gray-200 hover:border-green-300 bg-gradient-to-r from-green-50 to-white p-5 transition-all hover:shadow-md">
                                             <div class="flex items-start justify-between gap-3">
                                                 <div class="flex-1 min-w-0">
                                                     <span class="text-xs font-bold text-green-600 uppercase tracking-wide">{{ $course->category?->name ?? 'Course' }}</span>
                                                     <h5 class="text-lg font-bold text-gray-900 mt-1 group-hover:text-green-600 transition-colors">{{ $course->title }}</h5>
                                                     <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                                                 </div>
                                                 <div class="flex-shrink-0">
                                                     <i class="ti ti-arrow-right text-green-600 text-xl group-hover:translate-x-1 transition-transform"></i>
                                                 </div>
                                             </div>
                                         </div>
                                     </a>
                                @empty
                                    <div class="rounded-xl border-2 border-dashed border-gray-300 p-8 text-center">
                                        <i class="ti ti-search text-gray-300 text-4xl block mb-3"></i>
                                        <p class="text-gray-600 font-medium">No recommendations yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Explore the course catalog to get started</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Statistics Cards -->
            <section>
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ti ti-chart-bar"></i> Your Statistics
                    </h2>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Enrolled -->
                    <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-green-600 uppercase tracking-wide">Courses Enrolled</p>
                                <p class="text-4xl font-bold text-green-900 mt-2">{{ $courseRoadmap->count() }}</p>
                            </div>
                            <i class="ti ti-book-2 text-green-300 text-5xl opacity-50"></i>
                        </div>
                    </div>

                    <!-- Almost Completed -->
                    <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Almost Done</p>
                                <p class="text-4xl font-bold text-emerald-900 mt-2">{{ $courseRoadmap->where('progress', '>=', 70)->count() }}</p>
                            </div>
                            <i class="ti ti-check-circle text-emerald-300 text-5xl opacity-50"></i>
                        </div>
                    </div>

                    <!-- Recommended -->
                    <div class="rounded-2xl bg-gradient-to-br from-teal-50 to-teal-100 border border-teal-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">Recommended</p>
                                <p class="text-4xl font-bold text-teal-900 mt-2">{{ $recommendedCourses->count() }}</p>
                            </div>
                            <i class="ti ti-star text-teal-300 text-5xl opacity-50"></i>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 border border-emerald-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">In Progress</p>
                                <p class="text-4xl font-bold text-emerald-900 mt-2">{{ $courseRoadmap->where('progress', '>', 0)->where('progress', '<', 100)->count() }}</p>
                            </div>
                            <i class="ti ti-progress-check text-emerald-300 text-5xl opacity-50"></i>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>

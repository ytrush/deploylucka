<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
            
            <!-- Welcome Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Selamat datang kembali 👋</h1>
                        <p class="text-gray-600 mt-1">{{ Auth::user()->name }}, pantau progres belajar Anda hari ini</p>
                    </div>
                    <a href="/courses" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg">
                        <i class="ti ti-book"></i>
                        <span>Explore Courses</span>
                    </a>
                </div>
            </div>

            <!-- Key Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Overall Progress -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-200">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs text-purple-600 font-semibold uppercase">Overall Completion</p>
                        <i class="ti ti-chart-pie text-purple-400 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-purple-900">{{ $completionRate }}%</p>
                    <div class="mt-2 w-full bg-purple-200 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-1.5 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>

                <!-- Average Quiz Score -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs text-blue-600 font-semibold uppercase">Avg Quiz Score</p>
                        <i class="ti ti-target text-blue-400 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-blue-900">{{ $avgQuizScore }}%</p>
                    <p class="text-xs text-blue-600 mt-2">{{ $totalQuizAttempts }} attempts</p>
                </div>

                <!-- Enrolled vs Completed -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 border border-green-200">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs text-green-600 font-semibold uppercase">Courses Progress</p>
                        <i class="ti ti-book text-green-400 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-green-900">{{ $completedCourses }}/{{ $enrolledCoursesCount }}</p>
                    <p class="text-xs text-green-600 mt-2">{{ $inProgressCourses }} in progress</p>
                </div>

                <!-- Total Certificates -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-5 border border-orange-200">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs text-orange-600 font-semibold uppercase">Certificates Ready</p>
                        <i class="ti ti-certificate text-orange-400 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-orange-900">{{ $certificateReadyCount }}</p>
                    <p class="text-xs text-orange-600 mt-2">Completed courses</p>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- All Courses Progress -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">All Your Courses</h2>
                                <p class="text-xs text-gray-500 mt-1">{{ $coursesProgress->count() }} courses enrolled</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="/roadmap" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                    <i class="ti ti-route"></i> Roadmap
                                </a>
                                <a href="/analytics" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    <i class="ti ti-chart-bar"></i> Analytics
                                </a>
                            </div>
                        </div>

                        @if($coursesProgress->isNotEmpty())
                            <div class="space-y-2.5">
                                @foreach($coursesProgress as $item)
                                    @php
                                        $progress = (int) ($item->progress ?? 0);
                                        $statusColor = match(true) {
                                            $progress >= 100 => ['bg-green-50', 'border-green-200', 'text-green-700'],
                                            $progress >= 50 => ['bg-orange-50', 'border-orange-200', 'text-orange-700'],
                                            $progress > 0 => ['bg-blue-50', 'border-blue-200', 'text-blue-700'],
                                            default => ['bg-gray-50', 'border-gray-200', 'text-gray-700']
                                        };
                                        $progressBarColor = match(true) {
                                            $progress >= 100 => 'bg-gradient-to-r from-green-400 to-green-500',
                                            $progress >= 50 => 'bg-gradient-to-r from-orange-400 to-orange-500',
                                            $progress > 0 => 'bg-gradient-to-r from-blue-400 to-blue-500',
                                            default => 'bg-gray-300'
                                        };
                                    @endphp
                                    <a href="{{ route('courses.show', $item->course) }}" class="block border {{ $statusColor[1] }} rounded-lg p-3 hover:shadow-md transition-all duration-300 group" style="background-color: var(--bg-color);" onmouseover="this.style.backgroundColor='var(--hover-bg)'" onmouseout="this.style.backgroundColor='var(--bg-color)'">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 line-clamp-1 group-hover:text-orange-600">{{ $item->course->title }}</h4>
                                                <p class="text-xs text-gray-600 mt-0.5">{{ $item->completed }}/{{ $item->total }} lessons</p>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                @if($item->course->instructor)
                                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-orange-400 to-orange-500 flex items-center justify-center text-white text-xs font-bold" title="{{ $item->course->instructor->name }}">
                                                        {{ substr($item->course->instructor->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold border {{ $statusColor[1] }}" style="background-color: inherit; color: inherit;">
                                                    {{ $progress }}%
                                                </span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                            <div class="{{ $progressBarColor }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ti ti-inbox text-gray-300 text-4xl block mb-2"></i>
                                <p class="text-gray-500 text-sm">No courses enrolled yet</p>
                                <a href="/courses" class="text-orange-500 text-sm font-medium mt-3 inline-block hover:text-orange-600 inline-flex items-center gap-1">
                                    <i class="ti ti-arrow-right"></i> Start learning now
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h2>
                        <div class="space-y-3">
                            @if($recentCompletions->isNotEmpty())
                                @foreach($recentCompletions->take(3) as $completion)
                                    <div class="flex items-start gap-3 p-3 bg-green-50 border border-green-100 rounded-lg">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="ti ti-check text-green-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">Lesson completed</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $completion->materi->title ?? 'Unknown' }} in {{ $completion->materi->course->title ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $completion->completed_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-gray-500 text-sm py-4">No recent activity</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-8">
                    
                    <!-- User Profile Card -->
                    <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl shadow-sm p-6 text-white">
                        <div class="flex flex-col items-center text-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-white/30 flex items-center justify-center text-2xl font-bold mb-3">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h3 class="text-lg font-bold">{{ Auth::user()->name }}</h3>
                            <p class="text-orange-100 text-xs mt-1">{{ $achievementLabel ?? 'Learner' }}</p>
                        </div>
                        <div class="space-y-2 pt-4 border-t border-white/20">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-orange-100">Enrollment Status</span>
                                <span class="font-semibold">{{ $enrolledCoursesCount }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-orange-100">Completed</span>
                                <span class="font-semibold">{{ $completedCourses }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-orange-100">In Progress</span>
                                <span class="font-semibold">{{ $inProgressCourses }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Learning Stats</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <i class="ti ti-book text-purple-600"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Lessons Completed</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $completedMateris }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="ti ti-clipboard text-blue-600"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Quiz Attempts</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalQuizAttempts }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <i class="ti ti-certificate text-green-600"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Certificates Available</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $certificateReadyCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Courses -->
                    @if($recommendedCourses->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Recommended for You</h3>
                            <div class="space-y-2">
                                @foreach($recommendedCourses->take(3) as $course)
                                    <a href="{{ route('courses.show', $course) }}" class="block border border-gray-200 rounded-lg p-3 hover:border-orange-400 hover:bg-orange-50 transition-all duration-300 group">
                                        <p class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-orange-600">{{ $course->title }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-xs font-medium text-gray-500">{{ $course->category->name ?? 'Course' }}</span>
                                            @if($course->instructor)
                                                <span class="text-xs text-gray-400">by {{ $course->instructor->name }}</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
        
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600">
            <div class="absolute top-0 left-0 w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white rounded-full px-4 py-2 font-semibold text-sm border border-white/30 w-fit mb-4">
                            <i class="ti ti-chart-bar"></i> Analytics Dashboard
                        </div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">Your Learning Analytics</h1>
                        <p class="text-green-100 text-lg">Track your progress, quiz performance, and learning activity over time</p>
                    </div>

                    <!-- Period Filter -->
                    <form method="GET" action="{{ route('analytics') }}" class="flex-shrink-0">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-2 border border-white/20">
                            <div class="flex items-center gap-2">
                                <label for="period" class="text-white/80 text-sm font-medium pl-2 hidden sm:inline">Period:</label>
                                <select id="period" name="period" 
                                    class="rounded-lg bg-white/90 border-0 text-gray-900 px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-white/50 cursor-pointer">
                                    <option value="7" {{ $period === '7' ? 'selected' : '' }}>Last 7 Days</option>
                                    <option value="30" {{ $period === '30' ? 'selected' : '' }}>Last 30 Days</option>
                                    <option value="90" {{ $period === '90' ? 'selected' : '' }}>Last 90 Days</option>
                                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                                </select>
                                <button type="submit" class="bg-white text-green-600 px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-50 transition-all">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                @keyframes blob {
                    0%, 100% { transform: translate(0, 0) scale(1); }
                    33% { transform: translate(30px, -50px) scale(1.1); }
                    66% { transform: translate(-20px, 20px) scale(0.9); }
                }
                .animate-blob { animation: blob 7s infinite; }
                .animation-delay-2000 { animation-delay: 2s; }
            </style>
        </section>

        <!-- Stats Cards -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Enrolled Courses -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                             <i class="ti ti-book text-green-600 text-xl"></i>
                         </div>
                         <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Enrolled</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $enrolledCourses->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Courses Enrolled</p>
                </div>

                <!-- Completed Courses -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                             <i class="ti ti-check-circle text-emerald-600 text-xl"></i>
                         </div>
                         <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Done</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $completedCourses }}</p>
                    <p class="text-sm text-gray-500 mt-1">Courses Completed</p>
                </div>

                <!-- Average Progress -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center">
                             <i class="ti ti-trending-up text-teal-600 text-xl"></i>
                         </div>
                         <span class="text-xs font-semibold text-teal-600 bg-teal-50 px-2.5 py-1 rounded-full">Avg</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $averageCourseProgress }}%</p>
                    <p class="text-sm text-gray-500 mt-1">Avg. Progress</p>
                </div>

                <!-- Quiz Score -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                             <i class="ti ti-clipboard text-green-600 text-xl"></i>
                         </div>
                         <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Score</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $averageQuizScore }}%</p>
                    <p class="text-sm text-gray-500 mt-1">Avg. Quiz Score</p>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Progress Distribution Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                 <i class="ti ti-chart-bar text-green-600"></i> Progress Distribution
                             </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $period === 'all' ? 'All time' : $period . ' days' }} overview</p>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>

                <!-- Top Course Progress Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                 <i class="ti ti-trophy text-emerald-600"></i> Top Course Progress
                             </h3>
                            <p class="text-sm text-gray-500 mt-1">Your best performing courses</p>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="topCourseChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Activity Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Activity Summary -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                        <i class="ti ti-activity text-green-600"></i> Activity Summary
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                             <div class="flex items-center gap-3">
                                 <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                     <i class="ti ti-clipboard-list text-green-600"></i>
                                 </div>
                                 <div>
                                     <p class="text-sm font-medium text-gray-900">Total Quizzes</p>
                                     <p class="text-xs text-gray-500">All attempts</p>
                                 </div>
                             </div>
                             <p class="text-2xl font-bold text-green-600">{{ $totalQuizAttempts }}</p>
                         </div>
                        <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-xl">
                             <div class="flex items-center gap-3">
                                 <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                     <i class="ti ti-player-play text-emerald-600"></i>
                                 </div>
                                 <div>
                                     <p class="text-sm font-medium text-gray-900">In Progress</p>
                                     <p class="text-xs text-gray-500">Currently learning</p>
                                 </div>
                             </div>
                             <p class="text-2xl font-bold text-emerald-600">{{ $inProgressCourses }}</p>
                         </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <i class="ti ti-clock text-gray-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Not Started</p>
                                    <p class="text-xs text-gray-500">Waiting to begin</p>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-gray-600">{{ $notStartedCourses }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Quizzes -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                        <i class="ti ti-clipboard text-green-600"></i> Recent Quizzes
                    </h3>
                    <div class="space-y-3">
                        @forelse ($recentQuizAttempts as $attempt)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-green-50 transition-colors">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $attempt->materi?->title ?? 'Quiz' }}</p>
                                    <p class="text-xs text-gray-500">{{ $attempt->created_at?->format('M d, Y') }}</p>
                                </div>
                                <span class="ml-3 flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-bold
                                    {{ $attempt->percentage >= 70 ? 'bg-green-100 text-green-700' : ($attempt->percentage >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $attempt->percentage }}%
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <i class="ti ti-clipboard-off text-gray-300 text-3xl block mb-2"></i>
                                <p class="text-gray-500 text-sm">No quiz attempts yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Completions -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                        <i class="ti ti-check text-green-600"></i> Recent Completions
                    </h3>
                    <div class="space-y-3">
                        @forelse ($recentCompletions as $completion)
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="ti ti-check text-emerald-600 text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $completion->materi->title ?? 'Materi' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $completion->materi->course?->title ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $completion->completed_at?->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <i class="ti ti-circle-check text-gray-300 text-3xl block mb-2"></i>
                                <p class="text-gray-500 text-sm">No completions yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bucketLabels = @json(array_keys($courseBuckets));
            const bucketData = @json(array_values($courseBuckets));
            const courseLabels = @json($topCourseProgress->pluck('course.title')->all());
            const courseData = @json($topCourseProgress->pluck('progress')->all());

            // Progress Distribution Chart
            const progressCtx = document.getElementById('progressChart');
            if (progressCtx) {
                new Chart(progressCtx, {
                    type: 'bar',
                    data: {
                        labels: bucketLabels,
                        datasets: [{
                            label: 'Courses',
                            data: bucketData,
                            backgroundColor: ['#16a34a', '#059669', '#14b8a6', '#34d399'],
                            borderRadius: 8,
                            borderSkipped: false,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 8,
                            },
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                ticks: { precision: 0, color: '#94a3b8' },
                                grid: { color: '#f1f5f9' },
                            },
                            x: { 
                                ticks: { color: '#94a3b8' },
                                grid: { display: false },
                            },
                        },
                    },
                });
            }

            // Top Course Progress Chart
            const topCourseCtx = document.getElementById('topCourseChart');
            if (topCourseCtx) {
                new Chart(topCourseCtx, {
                    type: 'bar',
                    data: {
                        labels: courseLabels,
                        datasets: [{
                            label: 'Progress',
                            data: courseData,
                            backgroundColor: '#16a34a',
                            borderRadius: 8,
                            borderSkipped: false,
                        }],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) { return context.parsed.x + '%'; }
                                },
                            },
                        },
                        scales: {
                            x: { 
                                beginAtZero: true, 
                                max: 100, 
                                ticks: { stepSize: 20, color: '#94a3b8', callback: function(value) { return value + '%'; } },
                                grid: { color: '#f1f5f9' },
                            },
                            y: { 
                                ticks: { color: '#475569', font: { weight: 'bold' } },
                                grid: { display: false },
                            },
                        },
                    },
                });
            }
        });
    </script>
</x-app-layout>

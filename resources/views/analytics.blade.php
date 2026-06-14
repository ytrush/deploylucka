<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Analytics & Laporan Kemajuan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Pembelajaran</h3>
                        <p class="mt-2 text-sm text-gray-500">Lihat metrik utama dari progress course dan performa kuis Anda.</p>
                    </div>
                    <form method="GET" action="{{ route('analytics') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <label for="period" class="text-sm font-medium text-gray-700">Periode</label>
                        <select id="period" name="period" class="rounded-md border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="7" {{ $period === '7' ? 'selected' : '' }}>7 hari</option>
                            <option value="30" {{ $period === '30' ? 'selected' : '' }}>30 hari</option>
                            <option value="90" {{ $period === '90' ? 'selected' : '' }}>90 hari</option>
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua waktu</option>
                        </select>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Filter</button>
                    </form>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-4">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Course Terdaftar</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $enrolledCourses->count() }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Course Selesai</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $completedCourses }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Progress Rata-rata</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $averageCourseProgress }}%</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Skor Kuis Rata-rata</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $averageQuizScore }}%</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <h4 class="text-base font-semibold text-slate-900">Distribusi Progress Course</h4>
                        <span class="text-sm text-slate-500">Periode: {{ $period === 'all' ? 'Semua waktu' : $period . ' hari terakhir' }}</span>
                    </div>
                    <div class="mt-4">
                        <canvas id="progressChart" height="140"></canvas>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h4 class="text-base font-semibold text-slate-900">Detail Aktivitas</h4>
                    <div class="mt-4 space-y-4 text-sm text-slate-600">
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <span>Total Kuis</span>
                                <span class="font-semibold text-slate-900">{{ $totalQuizAttempts }}</span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <span>Course berjalan</span>
                                <span class="font-semibold text-slate-900">{{ $inProgressCourses }}</span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <span>Belum mulai</span>
                                <span class="font-semibold text-slate-900">{{ $notStartedCourses }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h4 class="text-base font-semibold text-slate-900">Top Course Progress</h4>
                <div class="mt-4">
                    <canvas id="topCourseChart" height="140"></canvas>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h4 class="text-base font-semibold text-slate-900">Kuis Terbaru</h4>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentQuizAttempts as $attempt)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-3 text-sm">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $attempt->materi?->title ?? 'Quiz' }}</p>
                                        <p class="text-slate-500">{{ $attempt->created_at?->format('d M Y H:i') }}</p>
                                    </div>
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ $attempt->percentage }}%</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                                Belum ada percobaan kuis.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h4 class="text-base font-semibold text-slate-900">Materi Selesai Terbaru</h4>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentCompletions as $completion)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="font-semibold text-slate-900">{{ $completion->materi->title ?? 'Materi' }}</p>
                                <p class="text-sm text-slate-500">Course: {{ $completion->materi->course?->title ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $completion->completed_at?->format('d M Y H:i') }}</p>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                                Belum ada materi yang diselesaikan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bucketLabels = @json(array_keys($courseBuckets));
            const bucketData = @json(array_values($courseBuckets));
            const courseLabels = @json($topCourseProgress->pluck('course.title')->all());
            const courseData = @json($topCourseProgress->pluck('progress')->all());

            const progressCtx = document.getElementById('progressChart');
            if (progressCtx) {
                new Chart(progressCtx, {
                    type: 'bar',
                    data: {
                        labels: bucketLabels,
                        datasets: [{
                            label: 'Jumlah Course',
                            data: bucketData,
                            backgroundColor: ['#6366f1', '#38bdf8', '#34d399'],
                            borderRadius: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } },
                        },
                    },
                });
            }

            const topCourseCtx = document.getElementById('topCourseChart');
            if (topCourseCtx) {
                new Chart(topCourseCtx, {
                    type: 'bar',
                    data: {
                        labels: courseLabels,
                        datasets: [{
                            label: 'Progress (%)',
                            data: courseData,
                            backgroundColor: '#4f46e5',
                            borderRadius: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            y: { beginAtZero: true, max: 100, ticks: { stepSize: 20 } },
                        },
                    },
                });
            }
        });
    </script>
</x-app-layout>

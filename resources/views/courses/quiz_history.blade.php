<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-1">
                <p class="text-sm text-gray-500">Home / My Courses / {{ $course->title }} / History / {{ $quizLabel }}
                </p>
                <h1 class="text-2xl font-semibold text-gray-900">History {{ $quizLabel }}: {{ $course->title }}</h1>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('courses.quiz', ['course' => $course, 'type' => $type]) }}"
                        class="inline-flex items-center rounded-full border border-indigo-200 bg-white px-5 py-2 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 transition">
                        Home / My Courses / {{ $course->title }} / History / {{ $quizLabel }}
                    </a>
                    <a href="{{ route('courses.quiz', ['course' => $course, 'type' => $type]) }}"
                        class="hover:text-indigo-600">
                        < Kembali ke Quiz</a>
                            <span>|</span>
                            <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:underline">Back
                                to Course ></a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Riwayat Percobaan</h2>
                    <div class="text-sm text-slate-600">Total: <span
                            class="font-semibold">{{ $attempts->count() }}</span></div>
                </div>

                @if ($attempts->isEmpty())
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">
                        Belum ada history quiz untuk course ini.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Persentase</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Benar/Total</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Poin</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($attempts as $attempt)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $attempt->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                            {{ $attempt->percentage }}%</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $attempt->earned_points }}/{{ $attempt->total_points }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($attempt->passed)
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">✓
                                                    Lulus</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">✗
                                                    Belum Lulus</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" onclick="toggleAttemptDetail({{ $attempt->id }})"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                Lihat
                                            </button>
                                        </td>
                                    </tr>
                                    <tr id="detail-{{ $attempt->id }}" class="hidden">
                                        <td colspan="6" class="px-4 py-4 bg-gray-50">
                                            <div class="space-y-3">
                                                <h5 class="font-semibold text-gray-900">Detail Jawaban</h5>
                                                @foreach ($attempt->answers as $idx => $answer)
                                                    <div
                                                        class="bg-white border rounded-lg p-3 {{ $answer->is_correct ? 'border-green-200' : 'border-red-200' }}">
                                                        <div class="flex justify-between items-start mb-2">
                                                            <span class="font-medium text-gray-900">Soal
                                                                {{ $idx + 1 }}:
                                                                {{ Str::limit($answer->question?->question ?? '-', 60) }}</span>
                                                            <span
                                                                class="text-xs {{ $answer->is_correct ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                                                {{ $answer->is_correct ? '✓ Benar' : '✗ Salah' }}
                                                            </span>
                                                        </div>
                                                        <div class="text-sm text-gray-600">
                                                            <p class="mb-1"><strong>Jawaban Anda:</strong>
                                                                {{ $answer->questionOption?->option_text ?? 'Tidak dijawab' }}
                                                            </p>
                                                            @if (!$answer->is_correct)
                                                                @php
                                                                    $correct = $answer->question?->options?->firstWhere(
                                                                        'is_correct',
                                                                        true,
                                                                    );
                                                                @endphp
                                                                @if ($correct)
                                                                    <p class="text-green-700"><strong>Jawaban
                                                                            Benar:</strong> {{ $correct->option_text }}
                                                                    </p>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleAttemptDetail(attemptId) {
            const element = document.getElementById('detail-' + attemptId);
            if (element) element.classList.toggle('hidden');
        }
    </script>
</x-app-layout>

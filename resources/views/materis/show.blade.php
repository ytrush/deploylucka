<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $materi->title }}</h2>
            <a href="{{ route('courses.show', $materi->course) }}" class="text-sm text-indigo-600 hover:text-indigo-800">←
                Kembali ke Course</a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Left Sidebar: Course Structure (same style as courses/quiz) -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sticky top-20">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">{{ $materi->course?->title }}</h3>

                        @php
                            $sections = $materi->course?->sections?->sortBy('order');
                            $materis = $materi->course?->materis?->sortBy('order');
                            $chunkSize =
                                $sections && $sections->count() > 0
                                    ? (int) ceil($materis->count() / $sections->count())
                                    : $materis?->count() ?? 0;
                        @endphp

                        @if ($sections && $sections->isNotEmpty())
                            @foreach ($sections as $section)
                                <div class="mb-3 rounded-2xl border border-slate-200 overflow-hidden">
                                    <button type="button"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-slate-100 text-left text-sm font-semibold text-slate-900">
                                        <div>
                                            <div>{{ $section->title }}</div>
                                            <div class="text-xs text-slate-500">Module {{ $section->order }}</div>
                                        </div>
                                        <span class="text-slate-400">▾</span>
                                    </button>
                                    <div class="space-y-2 p-4">
                                        @foreach ($materis->slice($loop->index * $chunkSize, $chunkSize) as $m)
                                            <a href="{{ route('materis.show', $m) }}"
                                                class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                                <span>{{ $m->order }}. {{ Str::limit($m->title, 24) }}</span>
                                                <span class="text-slate-400">›</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-3 rounded-2xl border border-slate-200 overflow-hidden">
                                <button type="button"
                                    class="w-full flex items-center justify-between px-4 py-3 bg-slate-100 text-left text-sm font-semibold text-slate-900">
                                    <div>
                                        <div>Module 1</div>
                                        <div class="text-xs text-slate-500">{{ $materi->course?->title }}</div>
                                    </div>
                                    <span class="text-slate-400">▾</span>
                                </button>
                                <div class="space-y-2 p-4">
                                    @foreach ($materis as $m)
                                        <a href="{{ route('materis.show', $m) }}"
                                            class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                            <span>{{ $m->order }}. {{ Str::limit($m->title, 24) }}</span>
                                            <span class="text-slate-400">›</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        <div
                            class="mt-4 rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-4 text-sm text-indigo-700">
                            <div class="font-semibold">Quiz Preview</div>
                            <div class="mt-2 text-xs text-slate-600">Kerjakan quiz untuk menguji pemahaman materi.</div>
                        </div>
                    </div>
                </div>


                <!-- Center: Video & Content -->
                <div class="md:col-span-2">
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
                    @endif

                    <!-- Video Player -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                        @if ($materi->video_url)
                            @php
                                $videoUrl = $materi->video_url;
                                $embedUrl = null;

                                if (
                                    preg_match(
                                        '/(?:youtube\.com\/watch\?v=|youtube\.com\/shorts\/|youtube\.com\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/',
                                        $videoUrl,
                                        $matches,
                                    )
                                ) {
                                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                                    $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                } elseif (str_ends_with($videoUrl, '.mp4') || str_contains($videoUrl, '.mp4?')) {
                                    $embedUrl = $videoUrl;
                                }
                                $embedParams = '';
                                if ($embedUrl && str_contains($embedUrl, 'youtube.com/embed')) {
                                    $embedParams =
                                        (str_contains($embedUrl, '?') ? '&' : '?') .
                                        'enablejsapi=1&origin=' .
                                        urlencode(request()->getSchemeAndHttpHost());
                                }
                            @endphp

                            @if ($embedUrl && str_contains($embedUrl, 'youtube.com/embed'))
                                <div class="bg-slate-900 aspect-video">
                                    <iframe id="materi-video-player" class="w-full h-full"
                                        src="{{ $embedUrl . $embedParams }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>
                            @elseif ($embedUrl && str_contains($embedUrl, 'player.vimeo.com'))
                                <div class="bg-slate-900 aspect-video">
                                    <iframe id="materi-video-player" class="w-full h-full" src="{{ $embedUrl }}"
                                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>
                            @elseif ($embedUrl)
                                <div class="bg-slate-900 aspect-video">
                                    <video id="materi-video-player" controls class="w-full h-full">
                                        <source src="{{ $embedUrl }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @else
                                <div class="bg-slate-900 aspect-video flex items-center justify-center">
                                    <div class="text-center text-gray-400">
                                        <p class="text-sm mb-2">Video tidak tersedia</p>
                                        <a href="{{ $materi->video_url }}" target="_blank"
                                            class="text-indigo-400 text-sm hover:underline">Buka link video</a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-slate-900 aspect-video flex items-center justify-center">
                                <p class="text-gray-400">Tidak ada video untuk materi ini</p>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $materi->title }}</h2>
                        <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $materi->content }}
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                        <h4 class="font-semibold mb-4">Diskusi ({{ $materi->comments->count() }})</h4>

                        <!-- Comment Form -->
                        <form action="{{ route('materis.comments.store', $materi) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <textarea name="content" rows="2"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        placeholder="Tulis komentar tentang video ini..." required></textarea>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Comments List -->
                        <div class="space-y-4">
                            @forelse ($materi->comments()->with('user')->get() as $comment)
                                <div class="border-b pb-4 last:border-b-0">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                                                <span
                                                    class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-1 text-gray-700 text-sm">{{ $comment->content }}</p>

                                            <!-- Reply Form -->
                                            <details class="mt-2">
                                                <summary
                                                    class="text-xs text-indigo-600 cursor-pointer hover:text-indigo-700">
                                                    Balas</summary>
                                                <form action="{{ route('materis.comments.store', $materi) }}"
                                                    method="POST" class="mt-2">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <div class="flex gap-2">
                                                        <input type="text" name="content"
                                                            class="flex-1 rounded-md border-gray-300 shadow-sm text-sm"
                                                            placeholder="Tulis balasan..." required>
                                                        <button type="submit"
                                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1 px-3 rounded-lg text-sm transition">
                                                            Kirim
                                                        </button>
                                                    </div>
                                                </form>
                                            </details>

                                            <!-- Replies -->
                                            @if ($comment->replies->count() > 0)
                                                <div class="mt-3 ml-4 space-y-3 border-l-2 border-indigo-100 pl-4">
                                                    @foreach ($comment->replies as $reply)
                                                        <div class="flex items-start gap-2">
                                                            <div
                                                                class="h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-semibold text-xs">
                                                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center gap-2">
                                                                    <span
                                                                        class="font-semibold text-xs">{{ $reply->user->name }}</span>
                                                                    <span
                                                                        class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                    @if ($reply->user_id === Auth::id())
                                                                        <form
                                                                            action="{{ route('comments.destroy', $reply) }}"
                                                                            method="POST" class="inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="text-xs text-red-500 hover:text-red-700"
                                                                                onclick="return confirm('Hapus?')">Hapus</button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                                <p class="mt-1 text-gray-700 text-xs">
                                                                    {{ $reply->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if ($comment->user_id === Auth::id())
                                                <form action="{{ route('comments.destroy', $comment) }}"
                                                    method="POST" class="mt-2 inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-500 hover:text-red-700"
                                                        onclick="return confirm('Hapus?')">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quiz Section -->
                    @if ($materi->questions->count() > 0)
                        <!-- Quiz History -->
                        @if ($quizAttempts->count() > 0)
                            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">📈 Riwayat Quiz</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50 border-b">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Tanggal</th>
                                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Skor
                                                </th>
                                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Benar/Total</th>
                                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Poin
                                                </th>
                                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Status</th>
                                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">
                                            @foreach ($quizAttempts as $attempt)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $attempt->created_at->format('d M Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                                        {{ $attempt->percentage }}%
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $attempt->correct_answers }}/{{ $attempt->total_questions }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $attempt->earned_points }}/{{ $attempt->total_points }}
                                                    </td>
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
                                                        <div class="flex gap-2 justify-center">
                                                            <button type="button"
                                                                onclick="toggleAttemptDetail({{ $attempt->id }})"
                                                                class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                                Lihat
                                                            </button>
                                                            @if ($attempt->passed)
                                                                <a href="{{ route('materis.certificate', $materi) }}"
                                                                    class="text-green-600 hover:text-green-800 font-medium text-sm">
                                                                    Sertifikat
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Detail Row -->
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
                                                                            {{ Str::limit($answer->question->question, 60) }}</span>
                                                                        <span
                                                                            class="text-xs {{ $answer->is_correct ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                                                            {{ $answer->is_correct ? '✓ Benar' : '✗ Salah' }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="text-sm text-gray-600">
                                                                        <p class="mb-1"><strong>Jawaban
                                                                                Anda:</strong>
                                                                            {{ $answer->questionOption?->option_text ?? 'Tidak dijawab' }}
                                                                        </p>
                                                                        @if (!$answer->is_correct)
                                                                            @php
                                                                                $correctOption = $answer->question->options->firstWhere(
                                                                                    'is_correct',
                                                                                    true,
                                                                                );
                                                                            @endphp
                                                                            @if ($correctOption)
                                                                                <p class="text-green-600">
                                                                                    <strong>Jawaban Benar:</strong>
                                                                                    {{ $correctOption->option_text }}
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
                            </div>
                        @endif

                        @if (isset($results))
                            <!-- Quiz Results -->
                            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">📊 Hasil Quiz</h3>
                                    <div
                                        class="inline-block px-4 py-2 rounded-lg {{ $results['passed'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        <p class="text-lg font-semibold">{{ $results['percentage'] }}% -
                                            {{ $results['passed'] ? '✓ LULUS' : '✗ BELUM LULUS' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                                        <p class="text-sm text-gray-600">Soal</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ $results['questions'] }}</p>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-lg text-center">
                                        <p class="text-sm text-gray-600">Benar</p>
                                        <p class="text-2xl font-bold text-green-600">{{ $results['correct'] }}</p>
                                    </div>
                                    <div class="bg-indigo-50 p-4 rounded-lg text-center">
                                        <p class="text-sm text-gray-600">Poin</p>
                                        <p class="text-2xl font-bold text-indigo-600">
                                            {{ $results['earned_points'] }}/{{ $results['total_points'] }}</p>
                                    </div>
                                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                                        <p class="text-sm text-gray-600">Presentase</p>
                                        <p class="text-2xl font-bold text-purple-600">{{ $results['percentage'] }}%
                                        </p>
                                    </div>
                                </div>

                                <!-- Answer Review -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-900 text-lg">Review Jawaban</h4>
                                    @foreach ($review as $idx => $item)
                                        <div
                                            class="border rounded-lg p-4 {{ $item['isCorrect'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                                            <div class="flex items-start justify-between mb-3">
                                                <h5 class="font-medium text-gray-900">
                                                    <span class="text-sm">Soal
                                                        {{ $idx + 1 }}{{ $item['isCorrect'] ? ' ✓' : ' ✗' }}</span>
                                                </h5>
                                                <span
                                                    class="text-xs font-semibold px-2 py-1 rounded {{ $item['isCorrect'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $item['isCorrect'] ? 'Benar' : 'Salah' }}
                                                </span>
                                            </div>
                                            <p class="text-gray-800 mb-3 font-medium">
                                                {{ $item['question']->question }}</p>

                                            <div class="space-y-2">
                                                <div class="text-sm">
                                                    <p class="text-gray-600 mb-1"><strong>Jawaban Anda:</strong></p>
                                                    <p class="pl-3 text-gray-800">
                                                        @if ($item['selectedOption'])
                                                            {{ $item['selectedOption']->option_text }}
                                                        @else
                                                            <span class="text-red-600">Tidak dijawab</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                @if (!$item['isCorrect'] && $item['correctOption'])
                                                    <div class="text-sm">
                                                        <p class="text-gray-600 mb-1"><strong>Jawaban Benar:</strong>
                                                        </p>
                                                        <p class="pl-3 text-green-700">
                                                            {{ $item['correctOption']->option_text }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-6 flex gap-3">
                                    @if ($results['passed'])
                                        <a href="{{ route('materis.certificate', $materi) }}"
                                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center font-medium">
                                            🎓 Lihat Sertifikat
                                        </a>
                                    @endif
                                    <a href="{{ route('courses.show', $materi->course) }}"
                                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-center font-medium">
                                        Kembali ke Course
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Quiz Form -->
                            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">📝 Quiz</h3>
                                <p class="text-gray-600 mb-6">Jumlah soal:
                                    <strong>{{ $materi->questions->count() }}</strong> | Total poin:
                                    <strong>{{ $materi->questions->sum('points') }}</strong>
                                </p>

                                <form action="{{ route('materis.quiz.submit', $materi) }}" method="POST"
                                    class="space-y-6">
                                    @csrf

                                    @foreach ($materi->questions as $idx => $question)
                                        <div class="border border-gray-200 rounded-lg p-5">
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-semibold text-gray-900 flex-1">
                                                    {{ $idx + 1 }}. {{ $question->question }}
                                                </h4>
                                                <span
                                                    class="ml-2 px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full whitespace-nowrap">
                                                    {{ $question->points }} poin
                                                </span>
                                            </div>

                                            <div class="space-y-2">
                                                @foreach ($question->options as $option)
                                                    <label
                                                        class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                                        <input type="radio" name="answers[{{ $question->id }}]"
                                                            value="{{ $option->id }}"
                                                            class="w-4 h-4 text-indigo-600" />
                                                        <span
                                                            class="ml-3 text-gray-700">{{ $option->option_text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="flex gap-3">
                                        <button type="submit"
                                            class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                                            Submit Quiz
                                        </button>
                                        <a href="{{ route('courses.show', $materi->course) }}"
                                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-center font-medium">
                                            Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Right Sidebar: Course Info -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-4 sticky top-20 space-y-4">
                        <!-- Course Info -->
                        <div class="pb-4 border-b">
                            <h4 class="text-xs font-semibold text-indigo-600 uppercase tracking-wide">Course Info</h4>
                            <p class="mt-2 text-sm font-medium text-gray-900">{{ $materi->course?->title }}</p>
                            @if ($materi->course?->instructor)
                                <p class="mt-1 text-xs text-gray-500">👤 {{ $materi->course?->instructor?->name }}</p>
                                @if ($materi->course?->instructor?->email)
                                    <p class="mt-1 text-xs text-gray-500">📧 <a
                                            href="mailto:{{ $materi->course->instructor->email }}"
                                            class="text-indigo-600 hover:text-indigo-800">{{ $materi->course->instructor->email }}</a>
                                    </p>
                                @endif
                            @endif
                        </div>

                        <!-- Materi Info -->
                        <div class="pb-4 border-b">
                            <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Materi Details</h4>
                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                <p>⏱ Durasi: <span class="font-medium">{{ $materi->duration }} menit</span></p>
                                <p>📚 Bab: <span class="font-medium">{{ $materi->order }}</span></p>
                            </div>
                        </div>

                        <div class="pb-4 border-b">
                            <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Status</h4>
                            <p id="completionBadge"
                                class="mt-2 text-sm font-medium {{ $videoCompleted ? 'text-emerald-700' : 'text-slate-600' }}">
                                {{ $videoCompleted ? 'Video sudah selesai ditonton.' : 'Video belum selesai.' }}
                            </p>
                        </div>

                        <!-- Category -->
                        @if ($materi->course?->category)
                            <div>
                                <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Kategori</h4>
                                <p
                                    class="mt-2 inline-block px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">
                                    {{ $materi->course?->category?->name }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (
        $materi->video_url &&
            (str_contains($materi->video_url, 'youtube.com') || str_contains($materi->video_url, 'youtu.be')))
        <script src="https://www.youtube.com/iframe_api"></script>
    @endif
    @if ($materi->video_url && str_contains($materi->video_url, 'vimeo.com'))
        <script src="https://player.vimeo.com/api/player.js"></script>
    @endif

    <script>
        function toggleAttemptDetail(attemptId) {
            const element = document.getElementById('detail-' + attemptId);
            if (element) {
                element.classList.toggle('hidden');
            }
        }

        const materiCompletionRoute = "{{ route('materis.complete', $materi) }}";
        const csrfToken = '{{ csrf_token() }}';
        let materiCompleted = @json(isset($videoCompleted) && $videoCompleted ? true : false);

        function updateCompletionBadge() {
            const badge = document.getElementById('completionBadge');
            if (!badge) {
                return;
            }

            if (materiCompleted) {
                badge.textContent = 'Video sudah selesai ditonton.';
                badge.classList.remove('text-slate-600');
                badge.classList.add('text-emerald-700');
            }
        }

        function markMateriCompleted() {
            if (materiCompleted) {
                return;
            }

            fetch(materiCompletionRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({}),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        materiCompleted = true;
                        updateCompletionBadge();
                    }
                })
                .catch(() => {
                    // ignore failures silently for now
                });
        }

        function initHtml5VideoTracking() {
            const video = document.getElementById('materi-video-player');
            if (!video || video.tagName !== 'VIDEO') {
                return;
            }

            video.addEventListener('ended', markMateriCompleted);
            video.addEventListener('timeupdate', () => {
                if (!materiCompleted && video.currentTime >= 15) {
                    markMateriCompleted();
                }
            });
        }

        function onYouTubeIframeAPIReady() {
            const player = new YT.Player('materi-video-player', {
                events: {
                    onStateChange: (event) => {
                        if (event.data === YT.PlayerState.PLAYING) {
                            markMateriCompleted();
                        }
                    },
                },
            });
        }

        function initVimeoTracking() {
            if (typeof Vimeo === 'undefined') {
                return;
            }

            const iframe = document.getElementById('materi-video-player');
            if (!iframe) {
                return;
            }

            const player = new Vimeo.Player(iframe);
            player.on('play', markMateriCompleted);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCompletionBadge();
            initHtml5VideoTracking();
            initVimeoTracking();
        });
    </script>
</x-app-layout>

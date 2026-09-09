<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Course</h2>
            <a href="{{ route('courses.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="w-full">
                        @if ($course->image)
                            <div class="mb-4 overflow-hidden rounded-2xl border border-slate-200">
                                <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                    class="h-64 w-full object-cover">
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Kategori: {{ $course->category?->name ?? '-' }}</p>
                        <p class="mt-1 text-sm text-gray-500">Instructor: {{ $course->instructor?->name }}</p>
                        @if ($course->instructor?->email)
                            <div
                                class="mt-3 inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-sm">
                                <span class="font-medium text-indigo-700">Kontak instruktur:</span>
                                <a href="mailto:{{ $course->instructor->email }}"
                                    class="font-semibold text-indigo-600 hover:text-indigo-800">
                                    {{ $course->instructor->email }}
                                </a>
                            </div>
                        @endif

                        <div class="mt-4 rounded-2xl bg-slate-50 p-4 border border-slate-200">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">Progress kursus</p>
                                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $progress }}%</p>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ count($completedMateriIds) }}/{{ $course->materis->count() }} selesai</p>
                            </div>
                            <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-indigo-600" style="width: {{ $progress }}%;">
                                </div>
                            </div>
                        </div>

                        @php
                            $user = Auth::user();
                            $isEnrolled = $user && $course->isEnrolledBy($user);
                            $isAdmin = $user && $user->hasAnyRole(['admin', 'super_admin', '2', '3']);
                        @endphp

                        @if (!empty($hasCertificate))
                            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-700">Sertifikat Siap!</p>
                                        <p class="text-sm text-emerald-600">Anda telah menyelesaikan semua materi.</p>
                                    </div>
                                    <a href="{{ route('courses.certificate', $course) }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                        Unduh Sertifikat
                                    </a>
                                </div>
                            </div>
                        @elseif ($user && !$isAdmin && !$isEnrolled)
                            <div class="mt-4 rounded-2xl border border-orange-200 bg-orange-50 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <p class="text-sm font-semibold text-orange-700">Belum terdaftar di course ini
                                        </p>
                                        <p class="text-sm text-orange-600">Daftar sekarang untuk membuka semua materi
                                            dan quiz.</p>
                                    </div>
                                    <form action="{{ url('/courses/' . $course->id . '/enroll') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 transition">
                                            Daftar Course
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <p class="mt-4 text-gray-700">{{ $course->description }}</p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h4 class="font-semibold mb-4">Materi</h4>
                <div class="space-y-2">
                    <!-- Pretest Section -->
                    <div class="rounded border border-indigo-200 bg-indigo-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="font-medium text-indigo-900">Pretest</div>
                                <div class="mt-1 text-sm text-indigo-700">Kerjakan pretest sebelum memulai materi</div>
                            </div>
                            <a href="{{ route('courses.quiz', ['course' => $course->id, 'type' => 'pretest']) }}"
                                class="ms-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                                Mulai
                            </a>
                            <a href="{{ route('courses.quiz.history', ['course' => $course->id, 'type' => 'pretest']) }}"
                                class="inline-flex items-center ml-2 justify-center rounded-md border border-indigo-200 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition">
                                History
                            </a>
                        </div>
                    </div>

                    <!-- Materi List -->
                    @forelse ($course->materis->sortBy('order') as $materi)
                        @php $isCompleted = in_array($materi->id, $completedMateriIds); @endphp
                        <div class="rounded border p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="font-medium">{{ $materi->order }}. {{ $materi->title }}</div>
                                    <div class="mt-1 text-sm text-gray-500">Durasi: {{ $materi->duration }} menit</div>
                                    @if ($isCompleted)
                                        <div
                                            class="mt-2 inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Selesai
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('materis.show', $materi) }}"
                                    class="ms-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                                    Lihat
                                </a>
                            </div>
                        </div>
                    @empty
                        <li class="text-sm text-gray-500">Belum ada materi.</li>
                    @endforelse

                    <!-- Pos Test Section -->
                    <div class="rounded border border-slate-700 bg-slate-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="font-medium text-slate-900">Pos Test</div>
                                <div class="mt-1 text-sm text-slate-700">Kerjakan pos test setelah menyelesaikan semua
                                    materi</div>
                            </div>
                            <a href="{{ route('courses.quiz', ['course' => $course->id, 'type' => 'posttest']) }}"
                                class="ms-4 bg-indigo-600 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                                Mulai
                            </a>
                            <a href="{{ route('courses.quiz.history', ['course' => $course->id, 'type' => 'posttest']) }}"
                                class="inline-flex items-center justify-center ml-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                History
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h4 class="font-semibold mb-4">Diskusi ({{ $course->comments->count() }})</h4>

                <!-- Comment Form -->
                <form action="{{ route('courses.comments.store', $course) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <textarea name="content" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Tulis komentar..." required></textarea>
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
                    @forelse ($course->comments()->with('user')->get() as $comment)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex items-start gap-3">
                                <div
                                    class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold">{{ $comment->user->name }}</span>
                                        <span
                                            class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>

                                    <!-- Reply Form -->
                                    <details class="mt-2">
                                        <summary class="text-sm text-indigo-600 cursor-pointer hover:text-indigo-700">
                                            Balas</summary>
                                        <form action="{{ route('courses.comments.store', $course) }}" method="POST"
                                            class="mt-2">
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
                                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-semibold text-sm">
                                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2">
                                                            <span
                                                                class="font-semibold text-sm">{{ $reply->user->name }}</span>
                                                            <span
                                                                class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                            @if ($reply->user_id === Auth::id())
                                                                <form action="{{ route('comments.destroy', $reply) }}"
                                                                    method="POST" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="text-xs text-red-500 hover:text-red-700"
                                                                        onclick="return confirm('Hapus komentar?')">Hapus</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-700">{{ $reply->content }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($comment->user_id === Auth::id())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                            class="mt-2 inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700"
                                                onclick="return confirm('Hapus komentar?')">Hapus</button>
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
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Course</h2>
            @if (auth()->user()
                    ?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <a href="{{ route('courses.create') }}"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">Tambah Course</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <!-- Filter Section -->
            <div class="mb-8 rounded-lg border bg-white p-4">
                <form method="GET" action="{{ route('courses.index') }}"
                    class="flex flex-col gap-3 md:flex-row md:items-end">
                    <div class="w-full md:w-64">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Filter Kategori</label>
                        <select id="category_id" name="category_id" class="mt-1 w-full rounded-md border-gray-300">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-96">
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Course</label>
                        <input id="search" name="search" type="text" value="{{ $search ?? '' }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Cari judul atau deskripsi course">
                    </div>

                    <div class="flex gap-2 items-end">
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">Terapkan</button>
                        <a href="{{ route('courses.index') }}"
                            class="rounded-md border px-4 py-2 text-sm hover:bg-gray-50">Reset</a>
                    </div>
                </form>
            </div>

            @if (!empty($recommendedCourses) && $recommendedCourses->isNotEmpty())
                <div class="mb-8 rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Rekomendasi untuk Anda</h3>
                            <p class="mt-1 text-sm text-gray-500">Course yang mungkin cocok untuk Anda berdasarkan
                                minat.</p>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($recommendedCourses as $recommendedCourse)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="text-xs font-semibold uppercase tracking-wide text-indigo-600">
                                    {{ $recommendedCourse->category?->name ?? 'Course' }}</div>
                                <h4 class="mt-2 text-base font-semibold text-slate-900">{{ $recommendedCourse->title }}
                                </h4>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit($recommendedCourse->description, 100) }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <a href="{{ route('courses.show', $recommendedCourse) }}"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lihat
                                        detail</a>
                                    <span
                                        class="text-xs text-slate-500">{{ $recommendedCourse->instructor?->name ?? 'Tutor' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Courses Grid -->
            @forelse ($courses as $course)
                @if ($loop->first)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @endif

                <!-- Course Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Course Image -->
                    <div class="relative bg-gradient-to-r from-indigo-500 to-blue-600 h-48 overflow-hidden">
                        @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-30" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Course Content -->
                    <div class="p-4">
                        <!-- Institution/Instructor -->
                        <p class="text-xs font-medium text-indigo-600 uppercase tracking-wide">
                            {{ $course->instructor?->name ?? 'Unknown Instructor' }}
                        </p>

                        <!-- Course Title -->
                        <h3
                            class="mt-2 text-lg font-bold text-gray-900 line-clamp-2 hover:text-indigo-600 cursor-pointer">
                            {{ $course->title }}
                        </h3>

                        <!-- Category -->
                        @if ($course->category)
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $course->category->name }}
                            </p>
                        @endif

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-medium text-gray-700">Progress</span>
                                <span
                                    class="text-xs font-bold text-gray-900">{{ $course->getProgressPercentage() }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all"
                                    style="width: {{ $course->getProgressPercentage() }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4 flex flex-col gap-2">
                            @auth
                                @if (in_array($course->id, $enrolledCourseIds))
                                    <!-- Already Enrolled -->
                                    <a href="{{ route('courses.show', $course) }}"
                                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-center text-sm transition">
                                        {{ $course->getProgressPercentage() > 0 ? 'Dive Back In' : 'Continue Learning' }}
                                    </a>
                                    <form action="{{ route('courses.disenroll', $course) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-red-600 hover:text-red-800 text-xs font-medium transition">
                                            Batalkan Pendaftaran
                                        </button>
                                    </form>
                                @else
                                    <!-- Not Enrolled -->
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                                            Daftar Course
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center text-sm transition">
                                    Login untuk Mendaftar
                                </a>
                            @endauth

                            @if (auth()->user()
                                    ?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                                <a href="{{ route('courses.edit', $course) }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg text-center text-sm transition">
                                    Edit
                                </a>
                            @endif
                        </div>

                        @if (auth()->user()
                                ?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-red-600 hover:text-red-800 text-xs font-medium transition"
                                    onclick="return confirm('Hapus course ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                @if ($loop->last)
        </div>
        @endif
    @empty
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m0 0h6m0-6h-6m0 0H6"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Belum ada course</h3>
            <p class="text-gray-500 mt-2">Mulai dengan menambahkan course baru</p>
            @if (auth()->user()
                    ?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <a href="{{ route('courses.create') }}"
                    class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Tambah Course
                </a>
            @endif
        </div>
        @endforelse

        <!-- Pagination -->
        @if ($courses->hasPages())
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
    </div>
</x-app-layout>

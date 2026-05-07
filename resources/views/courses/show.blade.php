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
                <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                <p class="mt-1 text-sm text-gray-500">Kategori: {{ $course->category?->name ?? '-' }}</p>
                <p class="mt-1 text-sm text-gray-500">Level: {{ $course->level }}</p>
                <p class="mt-1 text-sm text-gray-500">Instructor: {{ $course->instructor?->name }}</p>
                <p class="mt-4 text-gray-700">{{ $course->description }}</p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h4 class="font-semibold">Materi</h4>
                <ul class="mt-3 space-y-2">
                    @forelse ($course->materis->sortBy('order') as $materi)
                        <li class="rounded border p-3">
                            <div class="font-medium">{{ $materi->order }}. {{ $materi->title }}</div>
                            <div class="mt-1 text-sm text-gray-500">Durasi: {{ $materi->duration }} menit</div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Belum ada materi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

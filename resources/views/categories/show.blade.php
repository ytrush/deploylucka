<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Kategori</h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
                <p class="mt-1 text-sm text-gray-500">Jumlah course: {{ $category->courses->count() }}</p>
                @if ($category->description)
                    <p class="mt-4 text-gray-700">{{ $category->description }}</p>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h4 class="font-semibold">Course di kategori ini</h4>
                <ul class="mt-3 space-y-2">
                    @forelse ($category->courses as $course)
                        <li class="rounded border p-3">
                            <div class="font-medium">{{ $course->title }}</div>
                            <div class="mt-1 text-sm text-gray-500">Level: {{ $course->level }} | Instructor: {{ $course->instructor?->name }}</div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Belum ada course di kategori ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

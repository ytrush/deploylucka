<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Section</h2>
            <a href="{{ route('sections.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold">{{ $section->title }}</h3>
                <p class="mt-1 text-sm text-gray-500">Course: {{ $section->course?->title }}</p>
                <p class="mt-1 text-sm text-gray-500">Order: {{ $section->order }}</p>
            </div>

            <div class="rounded border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                Materi sekarang dikelola langsung dari Course, bukan dari Section.
            </div>
        </div>
    </div>
</x-app-layout>

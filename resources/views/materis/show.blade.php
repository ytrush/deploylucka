<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Materi</h2>
            <a href="{{ route('materis.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold">{{ $materi->title }}</h3>
                <p class="mt-1 text-sm text-gray-500">Course: {{ $materi->course?->title }}</p>
                <p class="mt-1 text-sm text-gray-500">Durasi: {{ $materi->duration }} menit</p>
                @if ($materi->video_url)
                    <p class="mt-1 text-sm text-gray-500">Video: <a href="{{ $materi->video_url }}" target="_blank" class="text-indigo-600">{{ $materi->video_url }}</a></p>
                @endif
                <div class="mt-4 whitespace-pre-line text-gray-700">{{ $materi->content }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

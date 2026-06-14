<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sertifikat Penyelesaian Materi</h2>
            <a href="{{ route('materis.show', $materi) }}" class="text-sm text-indigo-600">Kembali ke Materi</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="text-center">
                    <div class="text-sm uppercase tracking-[0.3em] text-slate-500">Sertifikat</div>
                    <h1 class="mt-4 text-4xl font-extrabold text-slate-900">Penyelesaian Materi</h1>
                    <p class="mt-3 text-sm text-slate-500">Diberikan kepada</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                    <p class="mt-2 text-lg text-slate-500">Untuk menyelesaikan materi</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $materi->title }}</p>

                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Tanggal Selesai</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">
                                {{ $completionDate?->format('d F Y') ?? now()->format('d F Y') }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Course</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">
                                {{ $materi->course?->title ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                        <button onclick="window.print()"
                            class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition">
                            Cetak Sertifikat
                        </button>
                        <a href="{{ route('materis.show', $materi) }}"
                            class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Kembali ke Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

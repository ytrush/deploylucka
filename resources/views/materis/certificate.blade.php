<x-app-layout>
    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

            .cert-seal {
                background: conic-gradient(from 0deg, #4f46e5, #059669, #4f46e5);
                box-shadow:
                    0 0 0 4px #ffffff,
                    0 0 0 8px #cbd5e1,
                    0 10px 25px 0 rgba(0, 0, 0, 0.15);
            }

            .ornament-divider {
                background: linear-gradient(90deg, transparent, #c7d2fe, transparent);
            }

            .parchment-texture {
                background-image:
                    radial-gradient(circle at 20% 80%, rgba(144, 238, 231, 0.4) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(135, 179, 247, 0.4) 0%, transparent 50%);
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sertifikat Penyelesaian Materi</h2>
            <a href="{{ route('materis.show', $materi) }}"
                class="text-sm text-indigo-600 hover:text-indigo-800 transition">Kembali ke Materi</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="relative rounded-3xl border-2 border-indigo-300 bg-gradient-to-br from-amber-50/40 via-white to-indigo-50/40 p-8 md:p-14 shadow-2xl">

                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div
                        class="absolute top-1/4 -left-1/4 h-[28rem] w-[28rem] rounded-full bg-indigo-200/25 opacity-50 blur-3xl">
                    </div>
                    <div
                        class="absolute bottom-1/4 -right-1/4 h-[28rem] w-[28rem] rounded-full bg-emerald-200/25 opacity-50 blur-3xl">
                    </div>
                </div>

                <div class="absolute inset-4 rounded-2xl border border-indigo-100/50 pointer-events-none"></div>

                <svg class="absolute top-4 left-4 h-8 w-8 text-indigo-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v2m0 14c-5.523 0-10-4.477-10-10S6.477 7 12 7s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <svg class="absolute top-4 right-4 h-8 w-8 text-indigo-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v2m0 14c-5.523 0-10-4.477-10-10S6.477 7 12 7s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <svg class="absolute bottom-4 left-4 h-8 w-8 text-indigo-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v2m0 14c-5.523 0-10-4.477-10-10S6.477 7 12 7s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <svg class="absolute bottom-4 right-4 h-8 w-8 text-indigo-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v2m0 14c-5.523 0-10-4.477-10-10S6.477 7 12 7s10 4.477 10 10-4.477 10-10 10z" />
                </svg>

                <div class="relative z-10">
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/Primary-Edumora.png') }}" alt="Edumora Logo"
                            class="h-16 w-auto drop-shadow-md">
                    </div>

                    <div class="flex justify-center mb-10">
                        <div
                            class="cert-seal mx-auto flex h-24 w-24 items-center justify-center rounded-full">
                            <svg class="h-10 w-10 text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2l2.9 5.9h5.9l-4.6 4.5 1.1 5.8-5.1-2.8-5.1 2.8 1.1-5.8-4.6-4.5h5.9z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mb-10 text-center">
                        <div
                            class="mx-auto w-fit rounded-full bg-indigo-100 px-6 py-2 text-xs font-semibold text-indigo-700 uppercase tracking-[0.3em]">
                            Certificate of Achievement
                        </div>
                    </div>

                    <h1
                        class="text-center text-4xl font-extrabold text-slate-900 mb-12 font-['Playfair_Display']">
                        Penyelesaian Materi
                    </h1>

                    <div class="text-center mb-12 space-y-5">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">
                            Diberikan kepada
                        </p>
                        <p
                            class="font-['Playfair_Display'] text-5xl font-bold text-indigo-700 tracking-wide">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-lg text-slate-500">
                            sebagai tanda bahwa telah menyelesaikan materi
                        </p>
                        <p class="text-2xl font-bold text-slate-800">
                            {{ $materi->title }}
                        </p>
                    </div>

                    <div class="mb-12">
                        <div class="ornament-divider h-px w-full my-8"></div>

                        <div class="mx-auto grid w-full max-w-3xl grid-cols-1 gap-6 sm:grid-cols-2">
                            <div
                                class="flex flex-col items-center gap-3 rounded-2xl border border-slate-200 bg-white/70 p-6 shadow-sm backdrop-blur-sm">
                                <svg class="h-6 w-6 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10a2 2 0 012 2v5a2 2 0 01-2 2h-4.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-1.414 0L5.293 15.707a1 1 0 01-.293-.707V9a2 2 0 012-7v5z" />
                                </svg>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">
                                    Tanggal Selesai
                                </p>
                                <p class="text-xl font-bold text-slate-900">
                                    {{ $completionDate?->format('d F Y') ?? now()->format('d F Y') }}
                                </p>
                            </div>

                            <div
                                class="flex flex-col items-center gap-3 rounded-2xl border border-slate-200 bg-white/70 p-6 shadow-sm backdrop-blur-sm">
                                <svg class="h-6 w-6 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">
                                    Course
                                </p>
                                <p class="text-xl font-bold text-slate-900">
                                    {{ $materi->course?->title ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="ornament-divider h-px w-full my-8"></div>
                    </div>

                    <div class="mb-12 flex flex-col justify-center gap-10 sm:flex-row">
                        <div class="flex-1 text-center">
                            <p class="mb-2 text-sm text-slate-500">
                                Tertanda
                            </p>
                            <div class="mx-auto mb-3 h-px w-48 bg-slate-400"></div>
                            <p class="font-semibold text-slate-800">
                                {{ $materi->course?->instructor?->name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                Instructor
                            </p>
                        </div>

                        <div class="hidden sm:block sm:w-px sm:bg-slate-300"></div>

                        <div class="flex-1 text-center">
                            <p class="mb-2 text-sm text-slate-500">
                                Dipercaya di
                            </p>
                            <div class="mx-auto mb-3 h-px w-48 bg-slate-400"></div>
                            <p class="font-semibold text-slate-800">Edumora</p>
                            <p class="text-xs text-slate-400">
                                Platform Edukasi
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-center pt-8 border-t border-slate-200">
                        <div class="flex flex-col items-center gap-1">
                            <p class="text-xs text-slate-400">
                                Certificate ID
                            </p>
                            <p class="font-mono text-sm font-semibold text-slate-700">
                                CERT-{{ strtoupper(\Str::random(8)) }}-{{ $materi->course?->id ?? $materi->id }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                        <button onclick="window.print()"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 hover:scale-105 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 17h2c.552 0 1 .448 1 1v2c0 .552-.448 1-1 1h-2m0-4h-4.5m4.5 0V7a2 2 0 10-4 0v10m4 0h-4m0 0H7a2 2 0 01-2-2V7a4 4 0 014-4h6a4 4 0 014 4v8a2 2 0 01-2 2h-4z" />
                            </svg>
                            Cetak Sertifikat
                        </button>
                        <a href="{{ route('materis.show', $materi) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-8 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:scale-105 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 19l-7-7 7-7m7 14l-7-7 7-7" />
                            </svg>
                            Kembali ke Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

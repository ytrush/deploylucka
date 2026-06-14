<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Learning Paths</h2>
            <a href="{{ route('learning-paths.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Tambah Learning Path</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="grid gap-6">
                    @forelse ($learningPaths as $learningPath)
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $learningPath->name }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ $learningPath->description }}</p>
                                    <p class="mt-3 text-xs uppercase tracking-wide text-slate-400">{{ $learningPath->courses_count }} course</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <a href="{{ route('learning-paths.edit', $learningPath) }}" class="rounded-md border border-indigo-600 px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">Edit</a>
                                    <form action="{{ route('learning-paths.destroy', $learningPath) }}" method="POST" onsubmit="return confirm('Hapus learning path ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                            Belum ada learning path. Buat learning path baru untuk mengatur kurikulum.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

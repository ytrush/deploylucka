<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Course</h2>
            @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <a href="{{ route('courses.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white">Tambah Course</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="mb-4 rounded-lg border bg-white p-4">
                <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col gap-3 md:flex-row md:items-end">
                    <div class="w-full md:w-64">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Filter Kategori</label>
                        <select id="category_id" name="category_id" class="mt-1 w-full rounded-md border-gray-300">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white">Terapkan</button>
                        <a href="{{ route('courses.index') }}" class="rounded-md border px-4 py-2 text-sm">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instructor</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($courses as $course)
                            <tr>
                                <td class="px-4 py-3">{{ $course->title }}</td>
                                <td class="px-4 py-3">{{ $course->category?->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $course->level }}</td>
                                <td class="px-4 py-3">{{ $course->instructor?->name }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('courses.show', $course) }}" class="text-indigo-600">Detail</a>
                                    @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                                        <a href="{{ route('courses.edit', $course) }}" class="text-amber-600">Edit</a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600" onclick="return confirm('Hapus course ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada course.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>

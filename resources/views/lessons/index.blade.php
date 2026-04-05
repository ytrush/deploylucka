<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Lesson</h2>
            @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <a href="{{ route('lessons.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white">Tambah Lesson</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durasi</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($lessons as $lesson)
                            <tr>
                                <td class="px-4 py-3">{{ $lesson->section?->title }}</td>
                                <td class="px-4 py-3">{{ $lesson->order }}</td>
                                <td class="px-4 py-3">{{ $lesson->title }}</td>
                                <td class="px-4 py-3">{{ $lesson->duration }} menit</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('lessons.show', $lesson) }}" class="text-indigo-600">Detail</a>
                                    @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                                        <a href="{{ route('lessons.edit', $lesson) }}" class="text-amber-600">Edit</a>
                                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600" onclick="return confirm('Hapus lesson ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada lesson.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $lessons->links() }}</div>
        </div>
    </div>
</x-app-layout>

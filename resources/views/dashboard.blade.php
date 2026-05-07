<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">Menu Belajar</h3>

                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-4">
                    <a href="{{ route('categories.index') }}" class="rounded border bg-white p-4 hover:bg-gray-50">
                        <div class="font-medium">Categories</div>
                        <div class="text-sm text-gray-500">Lihat daftar kategori</div>
                    </a>

                    <a href="{{ route('courses.index') }}" class="rounded border bg-white p-4 hover:bg-gray-50">
                        <div class="font-medium">Courses</div>
                        <div class="text-sm text-gray-500">Lihat daftar course</div>
                    </a>

                    <a href="{{ route('sections.index') }}" class="rounded border bg-white p-4 hover:bg-gray-50">
                        <div class="font-medium">Sections</div>
                        <div class="text-sm text-gray-500">Lihat section per course</div>
                    </a>

                    <a href="{{ route('materis.index') }}" class="rounded border bg-white p-4 hover:bg-gray-50">
                        <div class="font-medium">Materi</div>
                        <div class="text-sm text-gray-500">Lihat materi per course</div>
                    </a>
                </div>

                @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                    <div class="mt-6 rounded border border-amber-200 bg-amber-50 p-4">
                        <div class="font-medium text-amber-800">Akses Admin</div>
                        <div class="mt-1 text-sm text-amber-700">Kelola data lewat Filament panel.</div>
                        <a href="{{ url('/admin') }}" class="mt-3 inline-block rounded bg-amber-600 px-4 py-2 text-sm text-white">Buka Filament</a>
                    </div>
                @endif

                <div class="mt-6 text-sm text-gray-500">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

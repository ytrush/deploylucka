<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Artikel</h2>
            @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <a href="{{ route('articles.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">Tulis Artikel</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">{{ session('success') }}</div>
            @endif

            <!-- Articles Grid -->
            @if ($articles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow group">
                            <!-- Featured Image -->
                            <div class="relative bg-gradient-to-r from-blue-500 to-indigo-600 h-48 overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-30" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v9a2 2 0 01-2 2h-2zm-6-3a2 2 0 002-2v4a2 2 0 002 2v-4a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if ($article->category ?? false)
                                    <span class="absolute top-3 left-3 bg-white/90 px-2 py-1 text-xs font-semibold text-indigo-600 rounded">
                                        {{ $article->category }}
                                    </span>
                                @endif
                            </div>

                            <!-- Article Content -->
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 line-clamp-2">
                                    {{ $article->title }}
                                </h3>

                                @if ($article->excerpt)
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                        {{ $article->excerpt }}
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $article->author?->name ?? 'Unknown' }}</span>
                                    <span>{{ $article->published_at?->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v9a2 2 0 01-2 2h-2zm-6-3a2 2 0 002-2v4a2 2 0 002 2v-4a2 2 0 00-2-2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada artikel</h3>
                    <p class="text-gray-500 mt-2">Artikel akan muncul di sini setelah diterbitkan</p>
                </div>
            @endif

            <!-- Pagination -->
            @if ($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
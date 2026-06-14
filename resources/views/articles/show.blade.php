<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('articles.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            @if (auth()->user()?->hasAnyRole(['admin', 'super_admin', '2', '3']))
                <div class="flex items-center gap-2">
                    <a href="{{ route('articles.edit', $article) }}" class="text-amber-600 hover:text-amber-700">Edit</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Hapus artikel ini?')">Hapus</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Featured Image -->
                @if ($article->featured_image)
                    <div class="relative h-64 md:h-96 bg-gray-100 overflow-hidden">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <!-- Meta Info -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span>{{ $article->author?->name ?? 'Unknown' }}</span>
                        <span>•</span>
                        <span>{{ $article->published_at?->format('d M Y') }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                        {{ $article->title }}
                    </h1>

                    <!-- Excerpt -->
                    @if ($article->excerpt)
                        <p class="text-lg text-gray-600 mb-6 pb-6 border-b">
                            {{ $article->excerpt }}
                        </p>
                    @endif

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none text-gray-700 whitespace-pre-wrap">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
            </article>

            <!-- Back to list -->
            <div class="mt-6 text-center">
                <a href="{{ route('articles.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    ← Lihat semua artikel
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
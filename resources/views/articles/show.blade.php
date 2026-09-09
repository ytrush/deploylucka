<x-app-layout>
    <div class="bg-gradient-to-br from-green-50 via-white to-emerald-50 min-h-screen">
        <!-- Sticky Header Navigation -->
        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-green-600 font-semibold transition-colors">
                    <i class="ti ti-arrow-left text-lg"></i>
                    Back to Articles
                </a>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <span class="flex items-center gap-1">
                        <i class="ti ti-clock"></i>
                        5 min read
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="ti ti-eye"></i>
                        2,547 views
                    </span>
                </div>
            </div>
        </div>

        <article class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                
                <!-- Hero Section -->
                <div class="mb-12">
                    <!-- Meta Info -->
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 rounded-full px-4 py-2 mb-6 font-semibold text-sm">
                        <i class="ti ti-bookmark"></i> Article
                    </div>

                    <!-- Title -->
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $article->title }}
                    </h1>

                    <!-- Excerpt -->
                    @if ($article->excerpt)
                        <p class="text-xl text-gray-700 leading-relaxed mb-8 border-l-4 border-green-500 pl-6 py-2">
                            {{ $article->excerpt }}
                        </p>
                    @endif

                    <!-- Article Meta -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-6 pb-8 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($article->author?->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ $article->author?->name ?? 'Unknown' }}</p>
                                <p class="text-gray-600">
                                    <i class="ti ti-calendar-event mr-1"></i>
                                    {{ $article->published_at?->format('F d, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="sm:ml-auto flex items-center gap-6 text-sm text-gray-600 flex-wrap">
                            <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-lg">
                                <i class="ti ti-clock text-green-600"></i>
                                <span>5 min read</span>
                            </div>
                            <div class="flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-lg">
                                <i class="ti ti-eye text-emerald-600"></i>
                                <span>2,547 views</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($article->featured_image)
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl mb-12 h-96 md:h-96">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                @endif

                <!-- Article Content -->
                <div class="prose prose-lg max-w-none mb-16">
                    <style>
                        .prose {
                            --tw-prose-body: #111827;
                            --tw-prose-headings: #111827;
                            --tw-prose-lead: #4b5563;
                            --tw-prose-links: #16a34a;
                            --tw-prose-bold: #111827;
                            --tw-prose-counters: #6b7280;
                            --tw-prose-bullets: #d1d5db;
                            --tw-prose-hr: #e5e7eb;
                            --tw-prose-quotes: #111827;
                            --tw-prose-quote-borders: #16a34a;
                            --tw-prose-captions: #6b7280;
                            --tw-prose-code: #111827;
                            --tw-prose-pre-code: #e5e7eb;
                            --tw-prose-pre-bg: #1f2937;
                            --tw-prose-th-borders: #d1d5db;
                            --tw-prose-td-borders: #e5e7eb;
                        }
                        .prose h2 {
                            @apply text-3xl font-bold mt-12 mb-6 text-gray-900;
                        }
                        .prose h3 {
                            @apply text-2xl font-bold mt-8 mb-4 text-gray-900;
                        }
                        .prose p {
                            color: #374151;
                            line-height: 1.625;
                            margin-bottom: 1rem;
                            margin-top: 1rem;
                            font-size: 1rem;
                            text-align: justify;
                        }
                        .prose a {
                            @apply text-green-600 hover:text-green-700 font-semibold underline;
                        }
                        .prose strong {
                            @apply font-bold text-gray-900;
                        }
                        .prose code {
                            @apply bg-gray-100 px-3 py-1 rounded text-sm text-red-600 font-mono;
                        }
                        .prose pre {
                            @apply bg-gray-900 text-gray-100 rounded-xl p-6 overflow-x-auto shadow-lg;
                        }
                        .prose pre code {
                            @apply bg-transparent text-inherit px-0 py-0;
                        }
                        .prose blockquote {
                            @apply border-l-4 border-green-500 pl-6 py-2 italic text-gray-700 bg-green-50 rounded-r-lg pr-6;
                        }
                        .prose ul, .prose ol {
                            @apply my-6 ml-6;
                        }
                        .prose li {
                            @apply mb-3 text-gray-700;
                        }
                        .prose hr {
                            @apply my-12 border-gray-300;
                        }
                    </style>
                    {!! $article->content_html !!}
                </div>

                <!-- Article Footer -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-200 mb-12">
                    <div class="flex items-center justify-between flex-wrap gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Share this article</h3>
                            <p class="text-gray-600">Help others discover this valuable content</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-green-500 hover:text-white hover:border-green-500 flex items-center justify-center transition-all">
                                <i class="ti ti-brand-facebook"></i>
                            </button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 flex items-center justify-center transition-all">
                                <i class="ti ti-brand-twitter"></i>
                            </button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-green-600 hover:text-white hover:border-green-600 flex items-center justify-center transition-all">
                                <i class="ti ti-brand-linkedin"></i>
                            </button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-800 hover:text-white hover:border-gray-800 flex items-center justify-center transition-all">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Related Articles Section -->
                <div class="border-t border-gray-200 pt-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ti ti-link"></i> Related Articles
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">You might also be interested in these</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-gray-200 hover:border-green-300 hover:-translate-y-1">
                                <div class="relative h-40 overflow-hidden bg-gradient-to-br from-green-400 to-emerald-500">
                                    <i class="absolute inset-0 flex items-center justify-center ti ti-photo text-white text-5xl opacity-20"></i>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition mb-2">Related Article Title {{ $i }}</h4>
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">Brief description of the related article goes here...</p>
                                    <button class="text-xs text-green-600 hover:text-green-700 font-bold flex items-center gap-1">
                                        <span>Read</span>
                                        <i class="ti ti-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Back to Articles CTA -->
                <div class="mt-16 text-center">
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        <i class="ti ti-arrow-left"></i>
                        Back to All Articles
                    </a>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>
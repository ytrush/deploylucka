<x-app-layout>
    <div class="bg-gradient-to-br from-green-50 via-white to-emerald-50 min-h-screen">
        
        <!-- Success Alert -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <div class="mb-6 rounded-lg bg-green-100 border border-green-200 p-4 text-green-700 flex items-start gap-3">
                    <i class="ti ti-check-circle text-lg mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($articles->isNotEmpty())
            <!-- Hero Header Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-12">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 rounded-full px-4 py-2 mb-4 font-semibold text-sm">
                        <i class="ti ti-book"></i> Insights & Stories
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">Articles & Insights</h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Explore expert insights, tips, and inspiring stories from our community of learners and educators</p>
                </div>
            </section>

            <!-- Featured Article Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @php $featured = $articles->first(); @endphp
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-gradient-to-r from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 border border-green-200">
                    <!-- Featured Content -->
                    <div>
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 rounded-full px-4 py-2 mb-6 font-semibold text-sm">
                            <i class="ti ti-star"></i> Featured Article
                        </div>
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">{{ $featured->title }}</h2>
                        <p class="text-gray-700 text-lg mb-6 leading-relaxed">{{ Illuminate\Support\Str::limit($featured->excerpt ?? $featured->content, 200) }}</p>
                        
                        <!-- Author Info -->
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-green-200">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold">
                                {{ substr($featured->author?->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $featured->author?->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-600">{{ $featured->published_at?->diffForHumans() }}</p>
                            </div>
                        </div>

                        <a href="{{ route('articles.show', $featured) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                            Read Full Article
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Featured Image -->
                    <div class="rounded-2xl overflow-hidden shadow-2xl h-96 md:h-full min-h-80">
                        @if ($featured->featured_image)
                            <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                <i class="ti ti-photo text-white text-8xl opacity-30"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Categories Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ti ti-tag"></i> Explore by Topic
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">Browse articles by category</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @php
                        $categories = ['UX/UI Design', 'React Development', 'Backend PHP', 'JavaScript Tips'];
                        $categoryIcons = ['UX/UI Design' => '🎨', 'React Development' => '⚛️', 'Backend PHP' => '🐘', 'JavaScript Tips' => '⚙️'];
                    @endphp
                    @foreach ($categories as $category)
                        <div class="group cursor-pointer">
                            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black rounded-2xl overflow-hidden h-48 flex items-center justify-center relative hover:shadow-xl transition-all duration-300 border border-gray-700 hover:border-green-500 hover:-translate-y-1">
                                <div class="text-center">
                                    <div class="text-6xl mb-3 group-hover:scale-125 transition-transform duration-300">{{ $categoryIcons[$category] ?? '📚' }}</div>
                                    <p class="text-white font-bold text-lg">{{ $category }}</p>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Latest Articles Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ti ti-news"></i> Latest Articles
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">Freshly published content</p>
                    </div>
                    <a href="#all-articles" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-bold hover:gap-3 transition-all">
                        View More <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($articles->take(2) as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all border border-gray-200 hover:border-green-300 hover:-translate-y-1 flex flex-col h-full">
                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden bg-gradient-to-br from-green-400 to-emerald-500">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="ti ti-photo text-white text-7xl opacity-20"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="bg-green-600 text-white px-4 py-2 text-xs font-bold rounded-full">Featured</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8 flex flex-col flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition mb-3">{{ $article->title }}</h3>
                                <p class="text-gray-600 mb-6 line-clamp-3 flex-1">{{ $article->excerpt ?? Illuminate\Support\Str::limit($article->content, 150) }}</p>
                                
                                <!-- Footer -->
                                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr($article->author?->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-900">{{ $article->author?->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $article->published_at?->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 text-xs text-gray-500">
                                        <i class="ti ti-eye"></i>
                                        <span>{{ rand(100, 5000) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- All Articles Grid -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" id="all-articles">
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ti ti-list"></i> All Articles
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">{{ $articles->total() }} articles in total</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($articles->skip(2)->take(6) as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-200 hover:border-green-300 hover:-translate-y-1 flex flex-col h-full">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-green-400 to-emerald-500">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="ti ti-photo text-white text-5xl opacity-20"></i>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 bg-green-600 text-white px-3 py-1 text-xs font-bold rounded-full">Article</span>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-1">
                                <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-green-600 transition mb-2 text-lg">{{ $article->title }}</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">{{ $article->excerpt ?? Illuminate\Support\Str::limit($article->content, 80) }}</p>
                                
                                <!-- Author & Meta -->
                                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-xs font-bold text-white">
                                            {{ substr($article->author?->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 truncate">{{ $article->author?->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $article->published_at?->format('M d') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.show', $article) }}" class="text-green-600 hover:text-green-700 font-bold text-sm group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                                        <span>Read</span>
                                        <i class="ti ti-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- Pagination -->
            @if ($articles->hasPages())
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex justify-center">
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
                        {{ $articles->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-200">
                    <i class="ti ti-article text-gray-300 text-8xl block mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900">No Articles Yet</h3>
                    <p class="text-gray-600 mt-2 text-lg">Articles will appear here once they are published</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
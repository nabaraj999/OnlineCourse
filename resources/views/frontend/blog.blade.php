<x-frontend-layout />
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">

<!-- Header Section -->
<header class="bg-primary text-white py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-5xl font-bold text-center animate-fade-in font-raleway">Our Blog</h1>
        <p class="text-center mt-4 text-light font-raleway">Discover our latest articles and insights</p>
    </div>
</header>

<!-- Main Content Section -->
<main class="container mx-auto px-4 py-16">
    @if($blogs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    @if($blog->image)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-64 object-cover animate-float">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            @if($blog->category)
                                <span class="absolute top-4 left-4 bg-secondary text-white text-sm font-raleway px-3 py-1 rounded-full">
                                    {{ $blog->category }}
                                </span>
                            @endif
                        </div>
                    @endif
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-primary mb-3 font-raleway hover:text-secondary transition-colors duration-300">
                            <a href="{{ route('blogs.show', $blog->slug) }}">{{ Str::limit($blog->title, 50) }}</a>
                        </h2>
                        <div class="flex items-center mb-4 text-gray-600">
                            <svg class="w-5 h-5 text-secondary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-raleway text-sm">By {{ $blog->author ?? 'Anonymous' }}</span>
                        </div>
                        <p class="text-gray-700 font-raleway mb-4 line-clamp-3">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                        <div class="flex justify-between items-center text-gray-600 font-raleway text-sm">
                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-secondary mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>{{ $blog->views }} Views</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <div class="mt-12">
            {{ $blogs->links('vendor.pagination.tailwind') }}
        </div> --}}
    @else
        <div class="bg-light border-l-4 border-primary text-primary p-6 rounded-lg text-center max-w-5xl mx-auto animate-fade-in">
            <p class="font-raleway text-lg mb-4">No blog posts available.</p>
            <p class="font-raleway text-gray-600">Check back later for new articles!</p>
        </div>
    @endif
</main>

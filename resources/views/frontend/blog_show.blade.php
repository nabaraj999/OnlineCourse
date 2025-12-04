<x-frontend-layout />
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">


<!-- Header Section -->
<header class="bg-primary text-white py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-5xl font-bold text-center animate-fade-in font-raleway">Blog Details</h1>
    </div>
</header>

<!-- Main Content Section -->
<main class="container mx-auto px-4 py-16">
    @if(isset($blog) && $blog)
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-300 max-w-5xl mx-auto">
            @if($blog->image)
                <div class="relative">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover animate-float">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    @if($blog->category)
                        <span class="absolute top-4 left-4 bg-secondary text-white text-sm font-raleway px-4 py-1 rounded-full animate-fade-in">
                            {{ $blog->category }}
                        </span>
                    @endif
                </div>
            @endif
            <div class="p-10">
                <h2 class="text-4xl font-bold text-primary mb-4 font-raleway hover:text-secondary transition-colors duration-300">{{ $blog->title }}</h2>
                <div class="flex justify-between items-center mb-6 text-gray-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-raleway">By {{ $blog->author ?? 'Anonymous' }}</span>
                    </div>
                    <span class="font-raleway">{{ $blog->created_at->format('M d, Y') }}</span>
                </div>
                <div class="prose max-w-none text-gray-700 font-raleway mb-8 leading-relaxed">
                    @php
                        echo $blog->content; // Render raw HTML content
                    @endphp
                </div>
                <div class="flex items-center justify-between text-gray-600 font-raleway">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Views: {{ $blog->views }}</span>
                    </div>
                    <span class="inline-block bg-light text-primary text-sm px-3 py-1 rounded-full capitalize">
                        {{ $blog->status }}
                    </span>
                </div>
            </div>
        </article>

        <!-- Back to Blogs Link -->
        <div class="mt-12 text-center">
            <a href="{{ route('blogs.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-full font-raleway text-lg hover:bg-secondary hover:shadow-lg transition-all duration-300">
                Back to All Blogs
            </a>
        </div>
    @else
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg text-center max-w-5xl mx-auto animate-fade-in">
            <p class="font-raleway text-lg mb-4">Error: Blog not found.</p>
            <p class="font-raleway text-gray-600 mb-6">The blog post you're looking for might have been removed, archived, or is not published yet.</p>
            <a href="{{ route('blogs.index') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-full font-raleway hover:bg-secondary hover:shadow-lg transition-all duration-300">
                Back to All Blogs
            </a>
        </div>
    @endif
</main>

<x-frontend-footer />

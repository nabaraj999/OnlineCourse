<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn</title>
    <!-- Include Raleway font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Updated Font Awesome to version 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Apply Raleway font globally, excluding Font Awesome classes */
        html,
        body,
        *:not(.fa, .fa-solid, .fa-regular, .fa-brands) {
            font-family: 'Raleway', sans-serif !important;
        }
    </style>
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <x-frontend-layout />

    <!-- Hero Section -->
    <div class="pt-32 pb-12 sm:pt-40 sm:pb-16 md:pt-20 md:pb-20 relative overflow-hidden bg-white pt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Left: Text Content -->
                <div class="md:w-1/2 text-center md:text-left animate-fade-in">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">Learn Without <span
                            class="text-yellow-500">Limits</span></h1>
                    <p class="mt-4 text-base sm:text-lg md:text-xl text-gray-600">Start, switch, or advance your career
                        with more than 5,000 courses, Professional Certificates, and degrees from world-class
                        universities and companies.</p>
                    <div
                        class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-medium transition duration-300 shadow-md transform hover:-translate-y-1 text-sm sm:text-base">Get
                            Started</a>
                        <a href="#courses"
                            class="border-2 border-blue-600 hover:border-yellow-500 text-blue-600 hover:text-yellow-500 px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-medium transition duration-300 text-sm sm:text-base">Explore
                            Courses</a>
                    </div>
                    <div class="mt-8 sm:mt-10 flex flex-wrap justify-center md:justify-start gap-4 sm:gap-6">
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full shadow-md">
                                <i class="fa-solid fa-users text-yellow-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg sm:text-xl">50K+</p>
                                <p class="text-xs sm:text-sm text-gray-600">Active Students</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full shadow-md">
                                <i class="fa-solid fa-book-open text-yellow-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg sm:text-xl">500+</p>
                                <p class="text-xs sm:text-sm text-gray-600">Courses</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full shadow-md">
                                <i class="fa-solid fa-chalkboard-teacher text-yellow-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg sm:text-xl">200+</p>
                                <p class="text-xs sm:text-sm text-gray-600">Expert Mentors</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right: Image and Animated Elements -->
                <div class="md:w-1/2 mt-10 md:mt-0 relative">
                    <div class="animate-float">
                        <img class="w-full max-w-md mx-auto" src="{{ Storage::url($company->background_image) }}"
                            alt="Online Learning">
                    </div>

                    <!-- Animated elements -->
                    <div
                        class="absolute top-10 left-10 md:left-20 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-float animation-delay-2000">
                        <i class="fa-solid fa-graduation-cap text-secondary text-2xl"></i>
                    </div>
                    <div
                        class="absolute bottom-10 right-10 md:right-20 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-float animation-delay-4000">
                        <i class="fa-solid fa-laptop-code text-secondary text-2xl"></i>
                    </div>
                    <div
                        class="absolute top-1/3 right-5 md:right-10 w-12 h-12 bg-secondary rounded-full shadow-lg flex items-center justify-center animate-float">
                        <i class="fa-solid fa-medal text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="courses" class="py-16 bg-primary bg-opacity-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-white">Popular Courses</h2>
                <p class="mt-4 text-lg text-white max-w-3xl mx-auto">
                    Discover our most popular courses designed to help you achieve your career goals
                </p>
                {{-- <p class="mt-2 text-sm text-gray-500">Debug: {{ $courses->count() }} courses fetched</p> --}}
            </div>


            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($courses as $course)
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                        <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                            class="w-full h-48 object-cover bg-gray-200" onerror="this.src='/images/placeholder.jpg';">
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary-100 text-blue-800">{{ $course->rating }}
                                    ★</span>
                                <span class="text-lg font-semibold text-green-600">NPR
                                    {{ number_format($course->discounted_price_npr, 2) }}</span>
                                @if (
                                    $course->active_status === 'active' &&
                                        $course->discount_percentage > 0 &&
                                        Carbon\Carbon::now()->setTimezone('Asia/Kathmandu')->between(
                                                Carbon\Carbon::parse($course->discount_valid_from),
                                                Carbon\Carbon::parse($course->discount_valid_to)))
                                    <span class="text-sm font-medium text-gray-500 line-through">NPR
                                        {{ number_format($course->original_price_npr, 2) }}</span>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-2">{{ $course->title }}</h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $course->syllabus }}</p>
                            <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                <span class="flex items-center"><i class="fa-regular fa-clock mr-1"></i>
                                    {{ $course->duration_days }} days</span>
                                <span class="flex items-center"><i class="fa-solid fa-chair mr-1"></i>
                                    {{ $course->available_seats }} seats left</span>
                            </div>
                            <a href="#"
                                class="mt-5 inline-block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-medium transition duration-300">Enroll
                                Now</a>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600">No active courses available at the moment.</p>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <a href="#"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-primary rounded-lg font-medium transition duration-300">
                    View All Courses
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>


    <section id="mentors" class="py-10 bg-light font-raleway sm:py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Heading -->
            <div class="text-center">
                <h2 class="text-2xl font-extrabold text-primary sm:text-3xl md:text-4xl">Meet Our Mentors</h2>
                <p class="mt-3 text-base text-gray-600 max-w-2xl mx-auto sm:text-lg">
                    Learn from industry experts with years of proven experience
                </p>
            </div>

            <!-- Cards -->
            <div class="mt-8 grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            @forelse ($teachers as $teacher)
                <div
                    class="relative group bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-transform duration-500 sm:hover:-translate-y-3 sm:hover:scale-[1.02] border border-light">
                    <!-- Full Cover Image -->
                    <div class="relative h-48 w-full sm:h-56">
                        @if ($teacher->logo)
                            <img src="{{ Storage::url($teacher->logo) }}" alt="{{ $teacher->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-primary flex items-center justify-center">
                                <i class="fa-solid fa-user-tie text-white text-5xl sm:text-6xl"></i>
                            </div>
                        @endif
                        <!-- Hover Overlay (Disabled on Mobile) -->
                        <div
                            class="absolute inset-0 bg-primary bg-opacity-70 flex items-center justify-center opacity-0 sm:group-hover:opacity-100 transition-opacity duration-500">
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="p-2 rounded-full border-2 border-white text-white hover:bg-secondary hover:border-secondary transition sm:p-3">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                                <a href="mailto:{{ $teacher->email }}"
                                    class="p-2 rounded-full border-2 border-white text-white hover:bg-secondary hover:border-secondary transition sm:p-3">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 text-center sm:p-6">
                        <!-- Subject -->
                        <p class="text-secondary font-semibold uppercase tracking-wide text-xs sm:text-sm">
                            {{ $teacher->subject ?? 'Expert' }}
                        </p>

                        <!-- Name -->
                        <h2 class="text-lg font-bold text-primary sm:text-2xl">
                            {{ $teacher->name }}
                        </h2>

                        <!-- Address -->
                        <p class="text-gray-600 text-xs sm:text-sm">
                            {{ $teacher->address ?? 'Location not specified' }}
                        </p>

                        <!-- Experience -->
                        <p class="text-gray-500 text-xs italic sm:text-sm">
                            {{ $teacher->experience ?? 'Experienced Professional' }}
                        </p>
                    </div>

                    <!-- Bottom Accent -->
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-secondary"></div>
                </div>
            @empty
                <p class="text-center text-gray-600 text-sm col-span-full sm:text-base">No active mentors available at
                    this time.</p>
            @endforelse
        </div>
        </div>
    </section>


    {{--
    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-primary bg-opacity-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="text-center">
  <h2 class="text-3xl font-bold text-white">What Our Students Say</h2>
  <p class="mt-4 text-lg text-white max-w-3xl mx-auto">
    Hear from our successful students who have transformed their careers with EduLearn
  </p>
</div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <div class="flex items-center text-yellow-400">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 italic">"The web development course completely changed my career path.
                        I went from zero coding experience to landing a junior developer role in just 6 months!"</p>
                    <div class="mt-6 flex items-center">
                        <div
                            class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                            JS</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Jessica Smith</h4>
                            <p class="text-secondary">Web Developer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <div class="flex items-center text-yellow-400">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 italic">"The data science program provided me with practical skills
                        that I immediately applied at work. The mentors are incredibly supportive and knowledgeable."
                    </p>
                    <div class="mt-6 flex items-center">
                        <div
                            class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                            MR</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Michael Rodriguez</h4>
                            <p class="text-secondary">Data Analyst</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <div class="flex items-center text-yellow-400">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 italic">"As a complete beginner in design, the UI/UX course was
                        exactly what I needed. The projects were challenging but so rewarding. Highly recommend!"</p>
                    <div class="mt-6 flex items-center">
                        <div
                            class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                            AP</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Amanda Patel</h4>
                            <p class="text-secondary">UX Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold">Latest Blogs</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Stay updated with the latest trends and
                    insights in education and technology</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Blog 1 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-primary flex items-center justify-center">
                        <i class="fa-solid fa-code text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Web Development</span>
                        <h3 class="mt-2 text-xl font-bold">10 JavaScript Frameworks to Learn in 2023</h3>
                        <p class="mt-2 text-gray-600">Discover the most popular and powerful JavaScript frameworks that
                            will dominate web development in the coming year.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog 2 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-primary flex items-center justify-center">
                        <i class="fa-solid fa-brain text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Data Science</span>
                        <h3 class="mt-2 text-xl font-bold">How AI is Transforming Education</h3>
                        <p class="mt-2 text-gray-600">Explore the ways artificial intelligence is revolutionizing how
                            we learn and teach in the digital age.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog 3 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-primary flex items-center justify-center">
                        <i class="fa-solid fa-briefcase text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Career Tips</span>
                        <h3 class="mt-2 text-xl font-bold">Preparing for Tech Interviews: A Complete Guide</h3>
                        <p class="mt-2 text-gray-600">Learn proven strategies to ace your next technical interview and
                            land your dream job in tech.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Contact CTA Banner -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold">Have Questions? Contact Us Today</h2>
            <p class="mt-4 text-lg max-w-3xl mx-auto">Our team is ready to answer your questions and help you start
                your learning journey</p>
            <div class="mt-8">
                <a href="{{ route('contact.create') }}"
                    class="inline-block bg-secondary hover:bg-opacity-90 text-white px-8 py-3 rounded-lg font-medium transition duration-300 shadow-md transform hover:-translate-y-1">Contact
                    Us</a>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script>
        // Active Navigation
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".nav-link");
            const currentHash = window.location.hash || "#home";

            links.forEach(link => {
                if (link.getAttribute("href") === currentHash) {
                    link.classList.add("border-b-2", "border-yellow-500", "text-blue-600", "font-semibold");
                } else {
                    link.classList.add("border-b-2", "border-transparent", "hover:border-gray-300",
                        "hover:text-gray-700");
                }
            });
        });

        // Dynamically adjust body padding based on top bar and navbar height
        function adjustContentPadding() {
            const topBar = document.querySelector('.bg-blue-600');
            const navbar = document.querySelector('nav');
            const totalHeight = (topBar ? topBar.offsetHeight : 0) + (navbar ? navbar.offsetHeight : 0);
            document.body.style.paddingTop = `${totalHeight}px`;
        }
        window.addEventListener('resize', adjustContentPadding);
        document.addEventListener('DOMContentLoaded', adjustContentPadding);
    </script>
</body>
<x-frontend-footer />

</html>

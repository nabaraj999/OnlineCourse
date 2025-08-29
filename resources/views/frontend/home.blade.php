    <x-frontend-layout />



    <!-- ✅ Hero Section -->
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
                                <i class="fas fa-users text-yellow-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg sm:text-xl">50K+</p>
                                <p class="text-xs sm:text-sm text-gray-600">Active Students</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full shadow-md">
                                <i class="fas fa-book-open text-yellow-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg sm:text-xl">500+</p>
                                <p class="text-xs sm:text-sm text-gray-600">Courses</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full shadow-md">
                                <i class="fas fa-chalkboard-teacher text-yellow-500 text-lg sm:text-xl"></i>
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
                        <i class="fas fa-graduation-cap text-secondary text-2xl"></i>
                    </div>
                    <div
                        class="absolute bottom-10 right-10 md:right-20 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-float animation-delay-4000">
                        <i class="fas fa-laptop-code text-secondary text-2xl"></i>
                    </div>
                    <div
                        class="absolute top-1/3 right-5 md:right-10 w-12 h-12 bg-secondary rounded-full shadow-lg flex items-center justify-center animate-float">
                        <i class="fas fa-medal text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Scripts -->
    <script>
        // Toggle Mobile Menu
        document.getElementById("mobile-menu-button").addEventListener("click", function() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });

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
            const totalHeight = topBar.offsetHeight + navbar.offsetHeight;
            document.body.style.paddingTop = `${totalHeight}px`;
        }
        window.addEventListener('resize', adjustContentPadding);
        document.addEventListener('DOMContentLoaded', adjustContentPadding);
    </script>
    </body>

    </html>

    <!-- Courses Section -->
 <section id="courses" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold">Popular Courses</h2>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Discover our most popular courses designed to help you achieve your career goals</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($courses as $course)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <span class="bg-primary bg-opacity-20 text-secondary text-sm font-medium px-3 py-1 rounded-full">{{ $course->rating }} ★</span>
                            <span class="text-lg font-bold text-primary">NPR {{ number_format($course->original_price_npr) }}</span>
                            @if ($course->discount?->percentage > 0)
                                <span class="line-through text-gray-500">NPR {{ number_format($course->original_price_npr, 2) }}</span>
                            @endif
                        </div>
                        <h3 class="mt-4 text-xl font-bold">{{ $course->title }}</h3>
 <!-- Using syllabus instead of description -->
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-gray-500"><i class="far fa-clock mr-2"></i>{{ $course->duration_days }} days</span>
                            <span class="text-gray-500"><i class="fas fa-chair mr-2"></i>{{ $course->available_seats }} seats left</span>
                        </div>
                        <a href="#" class="mt-6 inline-block w-full text-center bg-secondary hover:bg-opacity-90 text-white py-2 rounded-lg font-medium transition duration-300">Enroll Now</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="#" class="inline-flex items-center text-primary hover:text-secondary font-medium">
                View All Courses
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

    <!-- Mentors Section -->
    <section id="mentors" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold">Our Mentors</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Learn from industry experts with years of
                    experience</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Mentor 1 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="h-60 bg-primary flex items-center justify-center relative">
                        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                            <i class="fas fa-user-tie text-primary text-5xl"></i>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-primary bg-opacity-70 text-white p-3 transform translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold">Sarah Johnson</h3>
                        <p class="text-secondary">Web Development Expert</p>
                        <p class="mt-2 text-gray-600">10+ years experience at Google and Facebook</p>
                    </div>
                </div>

                <!-- Mentor 2 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="h-60 bg-primary flex items-center justify-center relative">
                        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                            <i class="fas fa-user-tie text-primary text-5xl"></i>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-primary bg-opacity-70 text-white p-3 transform translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold">Michael Chen</h3>
                        <p class="text-secondary">Data Scientist</p>
                        <p class="mt-2 text-gray-600">Lead Data Scientist at Amazon with PhD in Machine Learning</p>
                    </div>
                </div>

                <!-- Mentor 3 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="h-60 bg-primary flex items-center justify-center relative">
                        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                            <i class="fas fa-user-tie text-primary text-5xl"></i>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-primary bg-opacity-70 text-white p-3 transform translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold">Emma Rodriguez</h3>
                        <p class="text-secondary">UI/UX Designer</p>
                        <p class="mt-2 text-gray-600">Award-winning designer with expertise in mobile applications</p>
                    </div>
                </div>

                <!-- Mentor 4 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 group">
                    <div class="h-60 bg-primary flex items-center justify-center relative">
                        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                            <i class="fas fa-user-tie text-primary text-5xl"></i>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-primary bg-opacity-70 text-white p-3 transform translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white hover:text-secondary"><i
                                        class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold">David Kim</h3>
                        <p class="text-secondary">Digital Marketing Expert</p>
                        <p class="mt-2 text-gray-600">Helped businesses grow revenue by 200%+ with digital strategies
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-primary bg-opacity-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold">What Our Students Say</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Hear from our successful students who have
                    transformed their careers with EduLearn</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
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
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
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
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
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
                        <i class="fas fa-code text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Web Development</span>
                        <h3 class="mt-2 text-xl font-bold">10 JavaScript Frameworks to Learn in 2023</h3>
                        <p class="mt-2 text-gray-600">Discover the most popular and powerful JavaScript frameworks that
                            will dominate web development in the coming year.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog 2 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-primary flex items-center justify-center">
                        <i class="fas fa-brain text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Data Science</span>
                        <h3 class="mt-2 text-xl font-bold">How AI is Transforming Education</h3>
                        <p class="mt-2 text-gray-600">Explore the ways artificial intelligence is revolutionizing how
                            we learn and teach in the digital age.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog 3 -->
                <div
                    class="bg-light rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-primary flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-secondary font-medium">Career Tips</span>
                        <h3 class="mt-2 text-xl font-bold">Preparing for Tech Interviews: A Complete Guide</h3>
                        <p class="mt-2 text-gray-600">Learn proven strategies to ace your next technical interview and
                            land your dream job in tech.</p>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary hover:text-secondary font-medium">
                            Read More
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA Banner -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold">Have Questions? Contact Us Today</h2>
            <p class="mt-4 text-lg max-w-3xl mx-auto">Our team is ready to answer your questions and help you start
                your learning journey</p>
            <div class="mt-8">
                <a href="#"
                    class="inline-block bg-secondary hover:bg-opacity-90 text-white px-8 py-3 rounded-lg font-medium transition duration-300 shadow-md transform hover:-translate-y-1">Contact
                    Us</a>
            </div>
        </div>
    </section>

    {{-- <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuButton = document.getElementById('close-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('-translate-x-full');
            document.body.style.overflow = 'hidden';
        });

        closeMenuButton.addEventListener('click', function() {
            mobileMenu.classList.add('-translate-x-full');
            document.body.style.overflow = 'auto';
        });

        // Close menu when clicking on links
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('-translate-x-full');
                document.body.style.overflow = 'auto';
            });
        });
    </script>
 --}}

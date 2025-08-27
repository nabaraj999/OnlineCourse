


    <div class="gradient-bg text-white py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center text-sm">
            <div class="flex items-center space-x-6">
                <a href="tel:{{$company['phone_number'] }}" class="flex items-center space-x-2 hover:text-gray-200 transition duration-300">
                    <i class="fas fa-phone"></i>
                    <span>{{ $company['phone_number'] }}</span>
                </a>
                <a href="https://wa.me/{{ $company['whatsapp_number'] }}" class="flex items-center space-x-2 hover:text-gray-200 transition duration-300">
                    <i class="fab fa-whatsapp"></i>
                    <span>{{ $company['whatsapp_number'] }}</span>
                </a>
                <a href="mailto:{{ $company['email'] }}" class="flex items-center space-x-2 hover:text-gray-200 transition duration-300">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $company['email'] }}</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ $company['facebook_url'] }}" class="social-icon hover:text-gray-200">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="{{ $company['instagram_url'] }}" class="social-icon hover:text-gray-200">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon hover:text-gray-200">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="glass-effect shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
    @if(!empty($company['logo']))
        <img src="{{ Storage::url($company->logo) }}" alt="Company Logo" class="w-10 h-10 rounded-lg">
    @else
        {{-- Fallback initials if no logo --}}
        <div class="gradient-bg text-white p-2 rounded-lg floating-animation text-xl font-bold">
            {{ $company['short_name'] ?? 'EC' }}
        </div>
    @endif
</div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="nav-link text-gray-700 font-medium">Home</a>
                    <a href="#" class="nav-link text-gray-700 font-medium">Courses</a>
                    <a href="#" class="nav-link text-gray-700 font-medium">Testimonials</a>
                    <a href="#" class="nav-link text-gray-700 font-medium">Mentor</a>
                    <a href="#" class="nav-link text-gray-700 font-medium">Blog</a>
                    <a href="#" class="nav-link text-gray-700 font-medium">Gallery</a>
                </div>

                <!-- Search & Student Portal -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Search..."
                            class="search-box w-48 px-4 py-2 border-2 border-gray-200 rounded-full focus:outline-none focus:border-purple-500"
                        >
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <a href="#" class="gradient-bg text-white px-6 py-2 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition duration-300">
                        Student Portal
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="hamburger focus:outline-none" id="mobile-menu-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu fixed top-0 left-0 w-full h-full bg-white z-40 md:hidden" id="mobile-menu">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center">
                        <div class="gradient-bg text-white p-2 rounded-lg">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <span class="ml-2 text-xl font-bold text-gray-800">EduCorp</span>
                    </div>
                    <button class="hamburger active" id="close-menu-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <div class="space-y-6">
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Home</a>
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Courses</a>
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Testimonials</a>
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Mentor</a>
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Blog</a>
                    <a href="#" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition duration-300">Gallery</a>

                    <div class="pt-4">
                        <div class="relative mb-4">
                            <input
                                type="text"
                                placeholder="Search..."
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-full focus:outline-none focus:border-purple-500"
                            >
                            <i class="fas fa-search absolute right-4 top-4 text-gray-400"></i>
                        </div>
                        <a href="#" class="block gradient-bg text-white text-center px-6 py-3 rounded-full font-medium hover:shadow-lg transition duration-300">
                            Student Portal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

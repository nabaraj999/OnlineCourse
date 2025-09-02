<footer class="bg-gray-900 text-white py-8 sm:py-10 md:py-12">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-4">
            <!-- Branding -->
            <div>
                <span class="text-xl font-bold sm:text-2xl font-raleway">{{ $company->name ?? 'EduLearn' }}<span
                        class="text-secondary">Learn</span></span>
                <p class="mt-3 text-gray-400 text-sm sm:text-base break-words">
                    {{ $company->description ?? 'Empowering learners worldwide with quality education and expert mentorship.' }}
                </p>
                <div class="mt-4 flex space-x-3 sm:space-x-4">
                    @if ($company->facebook_url)
                        <a href="{{ $company->facebook_url }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 p-2">
                            <i class="fab fa-facebook text-xl sm:text-2xl"></i>
                        </a>
                    @endif
                    @if ($company->instagram_url)
                        <a href="{{ $company->instagram_url }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 p-2">
                            <i class="fab fa-instagram text-xl sm:text-2xl"></i>
                        </a>
                    @endif
                    @if ($company->twitter_url)
                        <a href="{{ $company->twitter_url }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 p-2">
                            <i class="fab fa-twitter text-xl sm:text-2xl"></i>
                        </a>
                    @endif
                    @if ($company->youtube_url)
                        <a href="{{ $company->youtube_url }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 p-2">
                            <i class="fab fa-youtube text-xl sm:text-2xl"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-base font-semibold sm:text-lg font-raleway text-primary">Quick Links</h3>
                <ul class="mt-3 space-y-1.5 sm:space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Home</a>
                    </li>
                    <li><a href="#courses"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Courses</a>
                    </li>
                    <li><a href="#testimonials"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Testimonials</a>
                    </li>
                    <li><a href="#blog"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Blog</a>
                    </li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">About
                            Us</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-base font-semibold sm:text-lg font-raleway text-primary">Support</h3>
                <ul class="mt-3 space-y-1.5 sm:space-y-2">
                    <li><a href="#"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">FAQ</a>
                    </li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Help
                            Center</a></li>
                    <li><a href="{{ route('terms_conditions') }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Terms
                            of Service</a></li>
                    <li><a href="{{ route('privacy_policy') }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Privacy
                            Policy</a></li>
                    <li><a href="{{ route('contact.create') }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-base font-semibold sm:text-lg font-raleway text-primary">Contact Info</h3>
                <ul class="mt-3 space-y-1.5 sm:space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-secondary mt-1 mr-2 sm:mr-3 text-xl sm:text-2xl"></i>
                        <span
                            class="text-gray-400 text-sm sm:text-base break-words">{{ $company->address ?? '123 Education St, Learning City' }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone text-secondary mt-1 mr-2 sm:mr-3 text-xl sm:text-2xl"></i>
                        <a href="tel:{{ $company->phone ?? '+12345678900' }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">{{ $company->phone ?? '+1 (234) 567-8900' }}</a>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope text-secondary mt-1 mr-2 sm:mr-3 text-xl sm:text-2xl"></i>
                        <a href="mailto:{{ $company->email ?? 'info@edulearn.com' }}"
                            class="text-gray-400 hover:text-secondary transition duration-300 text-sm sm:text-base py-1 px-2">{{ $company->email ?? 'info@edulearn.com' }}</a>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-registered text-secondary mt-1 mr-2 sm:mr-3 text-xl sm:text-2xl"></i>
                        <span class="text-gray-400 text-sm sm:text-base break-words">Registration Number:
                            {{ $company->registration_number ?? 'Not registered' }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-id-card text-secondary mt-1 mr-2 sm:mr-3 text-xl sm:text-2xl"></i>
                        <span class="text-gray-400 text-sm sm:text-base break-words">PAN Number:
                            {{ $company->pan_number ?? 'Not specified' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-6 sm:mt-10 sm:pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-400 text-sm sm:text-base">&copy; {{ now()->year }}
                {{ $company->name ?? 'EduLearn' }}. All rights reserved.</p>
        </div>
    </div>
</footer>

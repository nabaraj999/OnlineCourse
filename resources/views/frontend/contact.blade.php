<style>
    body {
        font-family: 'Raleway', sans-serif;
    }

    .divider {
        background: repeating-linear-gradient(45deg,
                #f8fafc,
                #f8fafc 10px,
                #e2e8f0 10px,
                #e2e8f0 20px);
        height: 20px;
    }

    .map-container {
        filter: grayscale(0.2) invert(0.9) contrast(1.2) hue-rotate(180deg);
        border-radius: 8px;
        overflow: hidden;
    }
</style>
<x-frontend-layout />
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
<body class="bg-lightBg text-gray-800 font-raleway">
    <!-- Header -->


    <main class="container mx-auto px-4 py-12">
        <!-- Page Title -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary mb-4">Get in Touch</h2>
            <p class="text-xl max-w-2xl mx-auto">Have questions about our courses? We're here to help and answer any
                questions you might have.</p>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Information -->
            <div class="w-full lg:w-2/5">
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h3 class="text-2xl font-semibold text-primary mb-6">Contact Information</h3>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg">Address</h4>
                                <p class="text-gray-600">123 Tech Street, Innovation District<br>San Francisco, CA 94103
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg">Email</h4>
                                <p class="text-gray-600">info@techlearn.com<br>support@techlearn.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-phone-alt text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg">Phone / WhatsApp</h4>
                                <p class="text-gray-600">+1 (555) 123-4567<br>+1 (555) 765-4321</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h4 class="font-medium text-lg mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="bg-primary/10 hover:bg-primary hover:text-white h-12 w-12 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-facebook-f text-primary hover:text-white"></i>
                            </a>
                            <a href="#"
                                class="bg-primary/10 hover:bg-primary hover:text-white h-12 w-12 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-instagram text-primary hover:text-white"></i>
                            </a>
                            <a href="#"
                                class="bg-primary/10 hover:bg-primary hover:text-white h-12 w-12 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-linkedin-in text-primary hover:text-white"></i>
                            </a>
                            <a href="#"
                                class="bg-primary/10 hover:bg-primary hover:text-white h-12 w-12 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-youtube text-primary hover:text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Section -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-semibold text-primary mb-4">Support Center</h3>
                    <p class="text-gray-600 mb-6">Find quick answers to common questions in our FAQ section or submit a
                        support ticket.</p>
                    <div class="space-y-4">
                        <a href="#" class="flex items-center text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-question-circle mr-3"></i>
                            <span>Frequently Asked Questions</span>
                        </a>
                        <a href="#" class="flex items-center text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-book mr-3"></i>
                            <span>Knowledge Base</span>
                        </a>
                        <a href="#" class="flex items-center text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-ticket-alt mr-3"></i>
                            <span>Submit a Support Ticket</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form & Map -->
            <div class="w-full lg:w-3/5">
                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h3 class="text-2xl font-semibold text-primary mb-6">Send us a Message</h3>
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-2">Your Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors @error('name') border-red-500 @enderror"
                                    placeholder="John Doe">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="john@example.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors @error('subject') border-red-500 @enderror"
                                placeholder="Course Inquiry">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-gray-700 mb-2">Your Message</label>
                            <textarea id="message" name="message" rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors @error('message') border-red-500 @enderror"
                                placeholder="Type your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 transform hover:-translate-y-1">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Google Map -->
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <h3 class="text-2xl font-semibold text-primary mb-4">Our Location</h3>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100940.14245968236!2d-122.43760000000001!3d37.75769999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1685480000000!5m2!1sen!2sus"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Divider -->
    <div class="divider my-12"></div>

    <!-- Footer -->

</body>

</html>

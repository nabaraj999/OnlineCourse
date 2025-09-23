<x-frontend-layout />
<section id="course-enroll" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary md:text-4xl">Enroll in {{ $course->title }}</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Complete the form below to secure your spot in this exciting course!
            </p>
        </div>

        <!-- Error/Success Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 mt-8" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 mt-8" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Course Summary -->
            <div class="lg:col-span-1 bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 md:text-3xl">Course Summary</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="flex items-center"><i class="fa-solid fa-book mr-2 text-primary"></i> <strong>Course:</strong> {{ $course->title }}</p>
                    <p class="flex items-center"><i class="fa-solid fa-calendar-day mr-2 text-primary"></i> <strong>Start Date:</strong> {{ $course->start_date ? Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}</p>
                    <p class="flex items-center"><i class="fa-solid fa-clock mr-2 text-primary"></i> <strong>Duration:</strong> {{ $course->duration_days }} days</p>
                    <p class="flex items-center"><i class="fa-solid fa-chair mr-2 text-primary"></i> <strong>Available Seats:</strong> {{ $course->available_seats }} seats left</p>
                    <p class="flex items-center"><i class="fa-solid fa-money-bill mr-2 text-primary"></i> <strong>Price:</strong> NPR {{ number_format($course->discounted_price_npr, 2) }}
                        @if ($course->active_status === 'active' &&
                            $course->discount_percentage > 0 &&
                            Carbon\Carbon::now()->setTimezone('Asia/Kathmandu')->between(
                                Carbon\Carbon::parse($course->discount_valid_from),
                                Carbon\Carbon::parse($course->discount_valid_to)))
                            <span class="ml-2 text-sm font-medium text-gray-500 line-through">NPR {{ number_format($course->original_price_npr, 2) }}</span>
                            <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $course->discount_percentage }}% Off
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Middle: Enrollment Form -->
            <div class="lg:col-span-1 bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 md:text-3xl">Enrollment Form</h3>
                <form action="{{ route('enrollments.store', $course->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone" id="phone" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your phone number (e.g., +977XXXXXXXXX)">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Comments -->
                    <div>
                        <label for="comments" class="block text-sm font-medium text-gray-700">Additional Comments (Optional)</label>
                        <textarea name="comments" id="comments" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                  placeholder="Any additional information or questions"></textarea>
                        @error('comments')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg">
                            Proceed to Payment <i class="fa-solid fa-credit-card ml-2"></i>
                        </button>
                        <a href="{{ route('courses.show', $course->id) }}"
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg">
                            Cancel <i class="fa-solid fa-times ml-2"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Right Side: Payment Methods -->
            <div class="lg:col-span-1 bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 md:text-3xl">Payment Methods</h3>
                <div class="space-y-6">
                    <!-- Bank Transfer / QR Methods -->
                    @foreach($paymentMethods as $method)
                        @if($method->active)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $method->method_name }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $method->description }}</p>
                                <p class="text-sm text-gray-600 mb-2"><strong>Account Holder:</strong> {{ $method->account_holder }}</p>
                                <p class="text-sm text-gray-600 mb-4"><strong>Amount:</strong> NPR {{ number_format($method->amount_number, 2) }}</p>
                                @if($method->qr)
                                    <div class="text-center mb-4">
                                        <img src="{{ $method->qr }}" alt="Payment QR Code" class="w-32 h-32 mx-auto rounded-lg shadow-md">
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <!-- Digital Wallets -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Digital Wallets</h4>
                        <div class="space-y-3">
                            <a href="#" onclick="initiateKhaltiPayment()" class="flex items-center justify-center w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg transition duration-300">
                                <i class="fa-solid fa-wallet mr-2"></i> Pay with Khalti
                            </a>
                            <a href="#" onclick="initiateESewaPayment()" class="flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition duration-300">
                                <i class="fa-solid fa-wallet mr-2"></i> Pay with eSewa
                            </a>
                            <a href="#" class="flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-300">
                                <i class="fa-solid fa-credit-card mr-2"></i> Pay with IME Pay
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-3 text-center">Redirects to secure payment gateway</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('courses.index') }}"
               class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-primary rounded-lg font-medium transition duration-300 shadow-md hover:shadow-lg">
                Back to All Courses
                <i class="fa-solid fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>
</section>

<script>
function initiateKhaltiPayment() {
    // Placeholder for Khalti integration - replace with actual Khalti JS SDK init
    alert('Redirecting to Khalti payment...');
    // Example: KhaltiCheckout('your_public_key').show({amount: {{ $course->discounted_price_npr * 100 }} });
}

function initiateESewaPayment() {
    // Placeholder for eSewa integration - replace with actual form submission
    alert('Redirecting to eSewa payment...');
    // Example: submit to eSewa endpoint with params
}
</script>
<x-frontend-footer />

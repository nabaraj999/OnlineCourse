<x-frontend-layout />
<section id="course-details" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary md:text-4xl">{{ $course->title }}</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Explore the details of this course and start your learning journey
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 mt-8" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 mt-8" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                @if (session('password'))
                    <p class="mt-2"><strong>Your Generated Password:</strong> {{ session('password') }}</p>
                @endif
                <div class="mt-4">
                    <h4 class="font-semibold">Enrollment Details:</h4>
                    <p><strong>Course:</strong> {{ $course->title }}</p>
                    <p><strong>Price Paid:</strong> NPR {{ number_format(session('payment_amount'), 2) }}</p>
                    <p><strong>Payment Method:</strong> {{ session('payment_method') }}</p>
                    <p><strong>Transaction ID:</strong> {{ session('reference_code') ?? 'N/A' }}</p>
                    <p><strong>Enrollment Date:</strong> {{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        @endif

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Side: Course Syllabus -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 md:text-3xl">Course Syllabus</h3>
                <div class="text-gray-600 prose prose-sm max-w-none prose-headings:text-gray-800 prose-headings:font-semibold prose-p:my-3 prose-ul:my-3 prose-li:my-2 space-y-4">
                    {!! $course->syllabus ?? 'No syllabus provided.' !!}
                </div>
            </div>

            <!-- Right Side: Course Photo, Details & Enrollment Form -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6 space-y-6">
                <!-- Course Photo -->
                <div class="w-full h-64 md:h-72 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                        class="w-full h-full object-cover" onerror="this.src='/images/placeholder.jpg';">
                </div>

                <!-- Price and Discount -->
                <div class="p-4 bg-gray-50 rounded-lg shadow-inner">
                    <span class="text-xl font-semibold text-green-600 md:text-2xl">
                        NPR {{ number_format($course->discounted_price_npr, 2) }}
                    </span>

                    @php
                        $nowNepal = \Carbon\Carbon::now('Asia/Kathmandu');
                        $discountActive = $course->active_status === 'active' &&
                            $course->discount_percentage > 0 &&
                            $course->discount_valid_from &&
                            $course->discount_valid_to &&
                            $nowNepal->between(\Carbon\Carbon::parse($course->discount_valid_from), \Carbon\Carbon::parse($course->discount_valid_to));
                    @endphp

                    @if ($discountActive)
                        <span class="block text-sm font-medium text-gray-500 line-through mt-1">
                            NPR {{ number_format($course->original_price_npr, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Additional Details -->
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="flex items-center"><i class="fa-solid fa-calendar-day mr-2 text-primary"></i>
                        <strong>Start Date:</strong>
                        {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}
                    </p>
                    <p class="flex items-center"><i class="fa-solid fa-clock mr-2 text-primary"></i>
                        <strong>Duration:</strong> {{ $course->duration_days }} days</p>
                    <p class="flex items-center"><i class="fa-solid fa-chair mr-2 text-primary"></i> <strong>Available
                            Seats:</strong> {{ $course->available_seats }} seats left</p>
                </div>

                <!-- Enrollment Form -->
                <div class="space-y-4" x-data="enrollmentForm()">
                    <h3 class="text-xl font-bold text-gray-900">Enroll in this Course</h3>

                    <form action="{{ route('courses.enroll', $course->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" id="full_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Enter your full name" value="{{ old('full_name') }}">
                            @error('full_name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Enter your email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="98XXXXXXXX" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Method Select - FIXED -->
<div>
    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
    <select
        name="payment_method"
        id="payment_method"
        required
        @change="updatePaymentDetails()"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    >
        <option value="" disabled selected>Select a payment method</option>
        @foreach ($payment_methods as $method)
            @if ($method->active)
                <option
                    value="{{ $method->id }}"
                    data-method="{{ htmlentities(json_encode($method->only(['method_name', 'account_holder', 'account_number', 'qr_code', 'instructions']))) }}"
                    {{ old('payment_method') == $method->id ? 'selected' : '' }}
                >
                    {{ $method->method_name }} ({{ $method->account_holder }})
                </option>
            @endif
        @endforeach
    </select>
    @error('payment_method')
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>

                        <!-- Dynamic Payment Details -->
                        <div x-show="selectedMethod" x-transition class="bg-blue-50 border border-blue-200 rounded-lg p-5 space-y-3">
                            <h4 class="font-semibold text-blue-900" x-text="selectedMethod.method_name"></h4>
                            <p><strong>Account Holder:</strong> <span x-text="selectedMethod.account_holder"></span></p>
                            <p><strong>Account Number:</strong> <span x-text="selectedMethod.account_number"></span></p>

                            <template x-if="selectedMethod.instructions">
                                <div class="text-sm text-gray-700" x-html="selectedMethod.instructions"></div>
                            </template>

                            <template x-if="selectedMethod.qr_code">
                                <div class="mt-3">
                                    <img :src="`{{ Storage::url('') }}${selectedMethod.qr_code.replace('public/', 'storage/')}`" alt="QR Code" class="w-48 h-48 mx-auto border rounded">
                                </div>
                            </template>
                        </div>

                        <!-- Payment Reference Code -->
                        <div x-show="selectedMethod">
                            <label for="reference_code" class="block text-sm font-medium text-gray-700">Payment Reference Code / Transaction ID</label>
                            <input type="text" name="reference_code" id="reference_code" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="e.g., TRX123456789" value="{{ old('reference_code') }}">
                            @error('reference_code')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Screenshot -->
                        <div x-show="selectedMethod">
                            <label for="payment_screenshot" class="block text-sm font-medium text-gray-700">Upload Payment Screenshot</label>
                            <input type="file" name="payment_screenshot" id="payment_screenshot" accept="image/*" required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('payment_screenshot')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg disabled:opacity-50"
                            :disabled="!selectedMethod">
                            Enroll Now <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </form>

                    <a href="#"
                        class="inline-block w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg">
                        Watch Demo Video <i class="fa-solid fa-play ml-2"></i>
                    </a>
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
function enrollmentForm() {
    return {
        selectedMethod: null,

        updatePaymentDetails() {
            const select = document.getElementById('payment_method');
            const option = select.options[select.selectedIndex];

            if (!option || !option.value) {
                this.selectedMethod = null;
                return;
            }

            // Read data from HTML data-* attribute
            const raw = option.getAttribute('data-method');
            if (!raw) {
                this.selectedMethod = null;
                return;
            }

            try {
                let details = JSON.parse(raw);

                // Fix QR path: public/ → storage/
                if (details.qr_code) {
                    details.qr_code = details.qr_code.replace('public/', 'storage/');
                }

                this.selectedMethod = details;
            } catch (e) {
                console.error('Failed to parse payment method data', e);
                this.selectedMethod = null;
            }
        },

        init() {
            // Auto-load if old input exists (after validation fail)
            const select = document.getElementById('payment_method');
            if (select.value) {
                this.updatePaymentDetails();
            }
        }
    }
}
</script>
<x-frontend-footer />

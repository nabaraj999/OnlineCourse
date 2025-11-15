<x-frontend-layout />

<section id="course-details" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary md:text-4xl">{{ $course->title }}</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Explore the details of this course and start your learning journey
            </p>
        </div>

        {{-- Success / Error Messages --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 mt-8">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 mt-8">
                {{ session('success') }}
                @if (session('password'))
                    <p class="mt-2"><strong>Your Password:</strong> {{ session('password') }}</p>
                @endif
                <div class="mt-4 text-sm space-y-1">
                    <p><strong>Course:</strong> {{ $course->title }}</p>
                    <p><strong>Paid:</strong> NPR {{ number_format(session('payment_amount'), 2) }}</p>
                    <p><strong>Method:</strong> {{ session('payment_method') }}</p>
                    <p><strong>Transaction ID:</strong> {{ session('reference_code') }}</p>
                    <p><strong>Date:</strong> {{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        @endif

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Left: Syllabus --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Course Syllabus</h3>
                <div class="text-gray-600 prose prose-sm max-w-none">
                    {!! $course->syllabus ?? '<p class="italic text-gray-500">No syllabus provided.</p>' !!}
                </div>
            </div>

            {{-- Right: Details + Enroll Form --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 space-y-6">

                {{-- Course Image --}}
                <div class="w-full h-64 md:h-72 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                        class="w-full h-full object-cover" onerror="this.src='/images/placeholder.jpg';">
                </div>

                {{-- Price --}}
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                    <span class="text-2xl font-bold text-green-600">
                        NPR {{ number_format($course->discounted_price_npr, 2) }}
                    </span>
                    @if ($course->discounted_price_npr < $course->original_price_npr)
                        <span class="block text-sm text-gray-500 line-through mt-1">
                            NPR {{ number_format($course->original_price_npr, 2) }}
                        </span>
                    @endif
                </div>

                {{-- Info Icons --}}
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="flex items-center">
                        <i class="fa-solid fa-calendar-day mr-2 text-primary"></i>
                        <strong>Start:</strong>
                        {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}
                    </p>
                    <p class="flex items-center">
                        <i class="fa-solid fa-clock mr-2 text-primary"></i>
                        <strong>Duration:</strong> {{ $course->duration_days }} days
                    </p>
                    <p class="flex items-center">
                        <i class="fa-solid fa-chair mr-2 text-primary"></i>
                        <strong>Seats Left:</strong> {{ $course->available_seats }}
                    </p>
                </div>

                {{-- Enroll Form --}}
                <div class="space-y-5">
                    <h3 class="text-xl font-bold text-gray-900">Enroll Now</h3>

                    <form action="{{ route('courses.enroll', $course->slug) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="John Doe" value="{{ old('full_name') }}">
                            @error('full_name')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="you@example.com" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone (Nepal)</label>
                            <input type="tel" name="phone" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="98XXXXXXXX" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Payment Method (Only if active) --}}
                        @if ($selected_payment_method)
                            <input type="hidden" name="payment_method" value="{{ $selected_payment_method->id }}">

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 space-y-4 text-sm">
                                <h4 class="font-semibold text-blue-900 text-lg">
                                    {{ $selected_payment_method->method_name }}
                                </h4>

                                <div class="space-y-2 text-gray-700">
                                    <p><strong>Holder:</strong> {{ $selected_payment_method->account_holder }}</p>
                                    <p><strong>A/C No:</strong> {{ $selected_payment_method->account_number }}</p>
                                </div>

                                @if ($selected_payment_method->instructions)
                                    <div class="text-xs text-gray-600 bg-blue-100 p-3 rounded">
                                        {!! nl2br(e($selected_payment_method->instructions)) !!}
                                    </div>
                                @endif

                                {{-- QR Code --}}
                                @if ($selected_payment_method->qr_code_url)
                                    <div class="mt-4 text-center">
                                        <div
                                            class="inline-block p-3 bg-white rounded-xl shadow-md border border-gray-200">
                                            <img src="{{ $selected_payment_method->qr_code_url }}" alt="Scan to Pay"
                                                class="w-56 h-56 object-contain">
                                        </div>
                                        <p class="mt-3 text-xs text-gray-600 font-medium">
                                            Pay: <strong>NPR
                                                {{ number_format($course->discounted_price_npr, 2) }}</strong>
                                        </p>
                                    </div>
                                @else
                                    <div
                                        class="w-56 h-56 mx-auto bg-gray-100 border-2 border-dashed rounded-xl flex items-center justify-center">
                                        <span class="text-xs text-gray-500">QR Not Available</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Transaction ID --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction ID</label>
                                <input type="text" name="reference_code" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="e.g., TRX123456" value="{{ old('reference_code') }}">
                                @error('reference_code')
                                    <span class="text-red-600 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Screenshot Upload --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Screenshot</label>
                                <input type="file" name="payment_screenshot" accept="image/*" required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('payment_screenshot')
                                    <span class="text-red-600 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                                Enroll Now <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-700 font-medium">No active payment method available.</p>
                            </div>
                        @endif
                    </form>

                    {{-- Demo Video Button --}}
                    <a href="#"
                        class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                        Watch Demo Video <i class="fa-solid fa-play ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Back to Courses --}}
        <div class="mt-10 text-center">
            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-primary rounded-lg font-medium transition shadow-md hover:shadow-lg">
                Back to Courses
                <i class="fa-solid fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>
</section>

<x-frontend-footer />

<x-frontend-layout>
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="min-h-screen bg-gradient-to-br from-light via-white to-indigo-50 font-raleway py-12">
        <!-- Hero & Content (same as yours) -->
        <div class="text-center py-16 px-6">
            <h1 class="text-5**
        <h1 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text
                bg-gradient-to-r from-primary to-secondary">
                {{ $course->title }}
            </h1>
            <p class="mt-6 text-xl text-gray-700 font-medium">
                by <span class="font-bold text-primary">{{ $course->teacher->name ?? 'Expert Instructor' }}</span>
                • {{ $course->company->name ?? 'Code IT Nepal' }}
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- LEFT: Syllabus -->
                <div class="lg:col-span-7">
                    <div
                        class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden h-full flex flex-col">
                        <div class="bg-gradient-to-r from-primary to-indigo-700 text-white p-8 text-center">
                            <i class="fa-solid fa-book-open-reader text-6xl mb-4"></i>
                            <h3 class="text-3xl font-bold">Course Syllabus</h3>
                        </div>
                        <div class="p-8 prose prose-lg max-w-none flex-1 overflow-y-auto">
                            {!! $course->syllabus ?? '<p class="text-center py-32 text-gray-400">Syllabus coming soon...</p>' !!}
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Enrollment Card -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-10">

                        <!-- Pending Warning -->
                        @if ($hasPending ?? false)
                            <div
                                class="mb-8 p-6 bg-yellow-100 border-2 border-yellow-400 rounded-2xl text-yellow-800 text-center font-bold text-lg">
                                <i class="fa-solid fa-clock mr-2"></i>
                                You already have a pending enrollment. Waiting for admin approval.
                            </div>
                        @endif

                        <!-- Price -->
                        @if ($course->active_discount)
                            <div class="text-center">
                                <p class="text-7xl font-black text-secondary">NPR
                                    {{ number_format($course->discounted_price_npr) }}</p>
                                <p class="text-4xl text-gray-400 line-through">NPR
                                    {{ number_format($course->original_price_npr) }}</p>
                                <span
                                    class="inline-block mt-4 px-8 py-3 bg-red-600 text-white rounded-full font-bold text-lg">
                                    {{ $course->discount_percentage_active }}% OFF!
                                </span>
                            </div>
                        @else
                            <p class="text-7xl font-black text-primary text-center">NPR
                                {{ number_format($course->discounted_price_npr) }}</p>
                        @endif

                        <div class="grid grid-cols-2 gap-6 my-8 text-center">
                            <div class="bg-primary/5 p-6 rounded-2xl">
                                <p class="text-sm uppercase font-bold text-gray-600">Start Date</p>
                                <p class="text-2xl font-black text-primary mt-2">
                                    {{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }}
                                </p>
                            </div>
                            <div class="bg-secondary/5 p-6 rounded-2xl">
                                <p class="text-sm uppercase font-bold text-gray-600">Seats Left</p>
                                <p class="text-2xl font-black text-red-600 mt-2">{{ $course->available_seats }}</p>
                            </div>
                        </div>

                        @if ($course->available_seats > 0 && !$hasPending ?? true)
                            <button onclick="openEnrollmentModal()"
                                class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-indigo-900 hover:to-primary text-white font-black text-3xl py-10 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                                ENROLL NOW
                            </button>
                        @else
                            <div class="w-full bg-gray-400 text-white font-bold text-2xl py-10 rounded-2xl text-center">
                                Enrollment Closed / Pending Approval
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ENROLLMENT MODAL -->
    <div id="enrollmentModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-md z-[9999] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-3xl max-w-4xl w-full max-h-[95vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary to-indigo-800 text-white p-10 text-center relative">
                <button onclick="closeEnrollmentModal()"
                    class="absolute top-6 right-8 text-white text-5xl hover:scale-125 transition">×</button>
                <h2 class="text-4xl font-black">Complete Your Enrollment</h2>
                <p class="mt-4 text-4xl font-black text-secondary">NPR
                    {{ number_format($course->discounted_price_npr) }}</p>
            </div>

            <form id="enrollForm" action="{{ route('courses.enroll.store') }}" method="POST"
                enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" required
                            class="w-full px-6 py-4 rounded-xl border focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                        <p class="error-text text-red-600 text-sm mt-1"></p>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required
                            class="w-full px-6 py-4 rounded-xl border focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                        <p class="error-text text-red-600 text-sm mt-1"></p>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Phone <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required placeholder="+977 ..."
                            class="w-full px-6 py-4 rounded-xl border focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                        <p class="error-text text-red-600 text-sm mt-1"></p>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Transaction Reference <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="reference_code" required
                            class="w-full px-6 py-4 rounded-xl border focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                        <p class="error-text text-red-600 text-sm mt-1"></p>
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-2">Payment Method <span class="text-red-500">*</span></label>
                    <select name="payment_method_id" required onchange="showPaymentDetails(this)"
                        class="w-full px-6 py-4 rounded-xl border focus:border-secondary focus:ring-4 focus:ring-secondary/20 transition text-lg">
                        <option value="">-- Select Payment Method --</option>
                        @foreach ($payment_methods as $method)
                            <option value="{{ $method->id }}"
                                data-qr="{{ $method->qr_code ? Storage::url($method->qr_code) : '' }}"
                                data-number="{{ $method->account_number }}"
                                data-holder="{{ $method->account_holder }}">
                                {{ $method->method_name }} - {{ $method->account_holder }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="paymentDetails"
                    class="hidden bg-gradient-to-r from-primary/5 to-indigo-50 border-2 border-dashed border-primary/30 rounded-2xl p-8 text-center">
                    <p class="text-lg font-bold text-primary mb-6">Send payment to:</p>
                    <img id="qrCode" src="" alt="QR"
                        class="mx-auto w-56 h-56 rounded-xl shadow-xl mb-6 hidden">
                    <div id="accountInfo" class="text-xl font-black text-primary"></div>
                </div>

                <div>
                    <label class="block font-bold mb-3">Upload Screenshot <span class="text-red-500">*</span></label>
                    <label for="screenshot"
                        class="block border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-primary cursor-pointer bg-gray-50">
                        <i class="fa-solid fa-cloud-arrow-up text-7xl text-gray-400 mb-4"></i>
                        <p class="text-xl font-semibold">Click to upload</p>
                        <div id="screenshotPreview" class="mt-8 hidden">
                            <img src="" alt="Preview" class="mx-auto max-h-96 rounded-xl shadow-2xl">
                        </div>
                    </label>
                    <input type="file" name="screenshot" id="screenshot" accept="image/*" required
                        class="hidden" onchange="previewScreenshot(event)">
                    <p class="error-text text-red-600 text-sm mt-1"></p>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-secondary hover:to-orange-600 text-white font-black text-2xl py-8 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                    SUBMIT ENROLLMENT
                </button>
            </form>

            <!-- Success Message -->
            <div id="successMessage" class="hidden p-16 text-center bg-gradient-to-b from-green-50 to-white">
                <i class="fa-solid fa-circle-check text-9xl text-green-600 mb-8 animate-bounce"></i>
                <h3 class="text-5xl font-black text-primary mb-6">Submitted Successfully!</h3>
                <p class="text-xl mb-8">We'll review your payment and approve soon.</p>
                <p class="text-lg text-gray-600">Your temporary password:</p>
                <code id="generatedPassword"
                    class="bg-gray-100 px-12 py-8 rounded-2xl text-4xl font-black text-secondary tracking-widest block mt-4"></code>
                <button onclick="closeEnrollmentModal()"
                    class="mt-10 px-10 py-5 bg-primary text-white font-bold rounded-xl hover:bg-indigo-900 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <style>
        .error-text:empty {
            display: none;
        }

        input.border-red-500 {
            border-color: #ef4444 !important;
        }
    </style>

    <script>
        function openEnrollmentModal() {
            document.getElementById('enrollmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEnrollmentModal() {
            document.getElementById('enrollmentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('enrollForm')?.reset();
            document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
            document.querySelectorAll('input, select').forEach(el => el.classList.remove('border-red-500'));
            document.getElementById('paymentDetails').classList.add('hidden');
            document.getElementById('screenshotPreview').classList.add('hidden');
            document.getElementById('successMessage').classList.add('hidden');
            document.getElementById('enrollForm').classList.remove('hidden');
        }

        function showPaymentDetails(select) {
            const details = document.getElementById('paymentDetails');
            const qr = document.getElementById('qrCode');
            const info = document.getElementById('accountInfo');
            const opt = select.options[select.selectedIndex];
            if (!opt.value) return details.classList.add('hidden');
            if (opt.dataset.qr) {
                qr.src = opt.dataset.qr;
                qr.classList.remove('hidden');
            }
            info.innerHTML = `${opt.dataset.holder}<br>Account: ${opt.dataset.number}`;
            details.classList.remove('hidden');
        }

        function previewScreenshot(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                document.querySelector('#screenshotPreview img').src = URL.createObjectURL(file);
                document.getElementById('screenshotPreview').classList.remove('hidden');
            }
        }

        // AJAX SUBMISSION WITH PERFECT ERROR HANDLING
        document.getElementById('enrollForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = document.getElementById('submitBtn');
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-3"></i> Processing...';

            // Clear old errors
            document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
            document.querySelectorAll('input, select').forEach(el => el.classList.remove('border-red-500'));

            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.ok ? r.json() : r.json().then(err => {
                    throw err
                }))
                .then(data => {
                    if (data.success) {
                        document.getElementById('generatedPassword').textContent = data.plain_password;
                        form.classList.add('hidden');
                        document.getElementById('successMessage').classList.remove('hidden');
                    }
                })
                .catch(err => {
                    if (err.errors) {
                        Object.keys(err.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) {
                                input.classList.add('border-red-500');
                                const errorP = input.parentNode.querySelector('.error-text');
                                if (errorP) errorP.textContent = err.errors[key][0];
                            }
                        });
                    } else {
                        alert(err.message || 'Something went wrong!');
                    }
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = original;
                });
        });
    </script>

    <x-frontend-footer />
</x-frontend-layout>

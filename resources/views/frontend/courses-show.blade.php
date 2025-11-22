<x-frontend-layout>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1E3A8A',
                    secondary: '#F59E0B',
                    light: '#F8FAFC'
                },
                fontFamily: {
                    raleway: ['Raleway', 'sans-serif']
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'fade-in': 'fadeIn 1.5s ease-in-out',
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                },
                keyframes: {
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' }
                    },
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' }
                    }
                }
            }
        }
    }
</script>

<div class="min-h-screen bg-gradient-to-br from-light via-white to-indigo-50 font-raleway py-12">

    <!-- Hero Title -->
    <div class="text-center py-16 px-6 animate-fade-in">
        <h1 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
            {{ $course->title }}
        </h1>
        <p class="mt-6 text-xl text-gray-700 font-medium">
            by <span class="font-bold text-primary">{{ $course->teacher->name ?? 'Expert Instructor' }}</span>
            • {{ $course->company->name ?? 'Code IT Nepal' }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- LEFT: Syllabus (60%) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden h-full flex flex-col animate-fade-in">
                    <div class="bg-gradient-to-r from-primary to-indigo-700 text-white p-8 text-center">
                        <i class="fa-solid fa-book-open-reader text-6xl mb-4 animate-float"></i>
                        <h3 class="text-3xl font-bold">Course Syllabus</h3>
                    </div>
                    <div class="p-8 prose prose-lg max-w-none flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-primary/50">
                        {!! $course->syllabus ?? '<div class="text-center py-32 text-gray-400"><i class="fa-solid fa-clock text-8xl mb-6"></i><p class="text-2xl italic">Syllabus will be updated soon...</p></div>' !!}
                    </div>
                </div>
            </div>

            <!-- RIGHT: Enrollment Card (40%) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-10 animate-fade-in animation-delay-500">
                    <div class="text-center space-y-10">

                        <!-- Price -->
                        @if($course->active_discount)
                            <div>
                                <p class="text-7xl font-black text-secondary">NPR {{ number_format($course->discounted_price_npr) }}</p>
                                <p class="text-4xl text-gray-400 line-through">NPR {{ number_format($course->original_price_npr) }}</p>
                                <span class="inline-block mt-4 px-8 py-3 bg-red-600 text-white rounded-full font-bold text-lg shadow-lg animate-pulse">
                                    {{ $course->discount_percentage_active }}% OFF – Limited Time!
                                </span>
                            </div>
                        @else
                            <p class="text-7xl font-black text-primary">NPR {{ number_format($course->discounted_price_npr) }}</p>
                        @endif

                        <!-- Info Cards -->
                        <div class="grid grid-cols-2 gap-6 text-center">
                            <div class="bg-primary/5 p-6 rounded-2xl border border-primary/10">
                                <p class="text-sm uppercase tracking-wider font-bold text-gray-600">Start Date</p>
                                <p class="text-2xl font-black text-primary mt-2">
                                    {{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }}
                                </p>
                            </div>
                            <div class="bg-secondary/5 p-6 rounded-2xl border border-secondary/10">
                                <p class="text-sm uppercase tracking-wider font-bold text-gray-600">Duration</p>
                                <p class="text-2xl font-black text-secondary mt-2">{{ $course->duration_days }} Days</p>
                            </div>
                        </div>

                        <!-- Seats Left -->
                        <div class="py-6">
                            <p class="text-2xl font-bold text-red-600">
                                Only {{ $course->available_seats }} Seats Left!
                            </p>
                        </div>

                        <!-- ENROLL BUTTON -->
                        @if($course->available_seats > 0 && $course->active_status === 'active')
                            <button onclick="openEnrollmentModal()"
                                class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-indigo-900 hover:to-primary text-white font-black text-3xl py-10 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-4 group">
                                <i class="fa-solid fa-graduation-cap text-5xl group-hover:rotate-12 transition-transform"></i>
                                ENROLL NOW
                                <i class="fa-solid fa-arrow-right text-4xl group-hover:translate-x-3 transition-transform"></i>
                            </button>
                        @else
                            <div class="w-full bg-gray-300 text-gray-700 font-bold text-2xl py-10 rounded-2xl text-center">
                                Enrollment Closed
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ENROLLMENT MODAL -->
<div id="enrollmentModal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[9999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-3xl max-w-4xl w-full max-h-[95vh] overflow-y-auto scrollbar-thin">
        <div class="bg-gradient-to-r from-primary to-indigo-800 text-white p-10 text-center relative">
            <button onclick="closeEnrollmentModal()" class="absolute top-6 right-8 text-white text-5xl hover:scale-125 transition">×</button>
            <h2 class="text-4xl font-black">Complete Your Enrollment</h2>
            <p class="mt-3 text-xl opacity-90">{{ $course->title }}</p>
            <p class="mt-4 text-4xl font-black text-secondary">NPR {{ number_format($course->discounted_price_npr) }}</p>
        </div>

        <form id="enrollForm" action="{{ route('courses.enroll.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="amount_paid" value="{{ $course->discounted_price_npr }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" required placeholder="+977 ..." class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Transaction ID / Reference Code <span class="text-red-500">*</span></label>
                    <input type="text" name="reference_code" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition text-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Payment Method <span class="text-red-500">*</span></label>
                <select name="payment_method_id" required onchange="showPaymentDetails(this)" class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/20 transition text-lg">
                    <option value="">-- Choose Payment Method --</option>
                    @foreach($payment_methods as $method)
                        <option value="{{ $method->id }}"
                                data-qr="{{ $method->qr_code ? Storage::url($method->qr_code) : '' }}"
                                data-number="{{ $method->account_number }}"
                                data-holder="{{ $method->account_holder }}">
                            {{ $method->method_name }} – {{ $method->account_holder }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Payment Details Box -->
            <div id="paymentDetails" class="hidden bg-gradient-to-r from-primary/5 to-indigo-50 border-2 border-dashed border-primary/30 rounded-2xl p-8 text-center">
                <p class="text-lg font-bold text-primary mb-6">Please send payment to:</p>
                <img id="qrCode" src="" alt="QR Code" class="mx-auto w-56 h-56 rounded-xl shadow-xl mb-6 hidden">
                <div id="accountInfo" class="text-xl font-black text-primary"></div>
            </div>

            <!-- FIXED: Screenshot Upload (Now Clickable!) -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">Upload Payment Screenshot <span class="text-red-500">*</span></label>

                <label for="screenshot" class="block border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-primary transition cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <i class="fa-solid fa-cloud-arrow-up text-7xl text-gray-400 mb-4"></i>
                    <p class="text-xl font-semibold">Click anywhere to upload screenshot</p>
                    <p class="text-sm text-gray-500">JPG, PNG • Max 5MB</p>

                    <div id="screenshotPreview" class="mt-8 hidden">
                        <img src="" alt="Preview" class="mx-auto max-h-96 rounded-xl shadow-2xl border-4 border-white">
                    </div>
                </label>

                <input type="file" name="screenshot" id="screenshot" accept="image/*" required class="hidden" onchange="previewScreenshot(event)">
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-secondary hover:to-orange-600 text-white font-black text-2xl py-8 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-4">
                SUBMIT ENROLLMENT
            </button>
        </form>

        <!-- Success Message -->
        <div id="successMessage" class="hidden p-16 text-center bg-gradient-to-b from-green-50 to-white">
            <i class="fa-solid fa-circle-check text-9xl text-green-600 mb-8 animate-bounce"></i>
            <h3 class="text-5xl font-black text-primary mb-6">Enrollment Successful!</h3>
            <p class="text-xl mb-8">Your account has been created. Use this password to login:</p>
            <code id="generatedPassword" class="bg-gray-100 px-12 py-8 rounded-2xl text-4xl font-black text-secondary tracking-widest"></code>
            <button onclick="closeEnrollmentModal()" class="mt-10 px-10 py-5 bg-primary text-white font-bold rounded-xl hover:bg-indigo-900 transition">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    .scrollbar-thin::-webkit-scrollbar { width: 8px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #1E3A8A; border-radius: 10px; }
    .animation-delay-500 { animation-delay: 0.5s; opacity: 0; animation: fadeIn 1.5s ease-out forwards; }
</style>

<script>
    // Open & Close Modal (unchanged)
    function openEnrollmentModal() {
        document.getElementById('enrollmentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEnrollmentModal() {
        document.getElementById('enrollmentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('enrollForm').reset();
        document.getElementById('paymentDetails').classList.add('hidden');
        document.getElementById('screenshotPreview').classList.add('hidden');
        document.getElementById('successMessage').classList.add('hidden');
        document.getElementById('enrollForm').classList.remove('hidden');
        document.getElementById('qrCode')?.classList.add('hidden');
    }

    // Payment details (unchanged)
    function showPaymentDetails(select) {
        const details = document.getElementById('paymentDetails');
        const qr = document.getElementById('qrCode');
        const info = document.getElementById('accountInfo');
        const selected = select.options[select.selectedIndex];

        if (!selected.value) {
            details.classList.add('hidden');
            return;
        }

        const qrUrl = selected.dataset.qr;
        const number = selected.dataset.number;
        const holder = selected.dataset.holder;

        if (qrUrl) {
            qr.src = qrUrl;
            qr.classList.remove('hidden');
        } else {
            qr.classList.add('hidden');
        }

        info.innerHTML = `${holder}<br>Account: ${number}`;
        details.classList.remove('hidden');
    }

    function previewScreenshot(event) {
        const preview = document.getElementById('screenshotPreview');
        const img = preview.querySelector('img');
        const file = event.target.files[0];

        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Please upload a valid image file.');
                event.target.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('File is too large. Maximum size is 5MB.');
                event.target.value = '';
                return;
            }
            img.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }

    // THIS IS THE MAIN FIX → AJAX SUBMISSION
    document.getElementById('enrollForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Stop page reload

        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Disable button + show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-3"></i> Processing...';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message with password
                document.getElementById('enrollForm').classList.add('hidden');
                document.getElementById('generatedPassword').textContent = data.plain_password;
                document.getElementById('successMessage').classList.remove('hidden');
            } else {
                alert(data.message || 'Enrollment failed. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            let message = 'Something went wrong. Please try again.';

            if (error.errors) {
                // Laravel validation errors
                const firstError = Object.values(error.errors)[0];
                message = Array.isArray(firstError) ? firstError[0] : firstError;
            } else if (error.message) {
                message = error.message;
            }

            alert(message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>

<x-frontend-footer />
</x-frontend-layout>

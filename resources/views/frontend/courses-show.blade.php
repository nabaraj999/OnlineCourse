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
                fontFamily: { raleway: ['Raleway', 'sans-serif'] },
                animation: {
                    fadeIn: 'fadeIn 0.8s ease-out forwards',
                    float: 'float 6s ease-in-out infinite',
                    glow: 'glow 2s ease-in-out infinite alternate'
                },
                keyframes: {
                    fadeIn: { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                    float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-15px)' } },
                    glow: { '0%': { boxShadow: '0 0 20px rgba(30,58,138,0.4)' }, '100%': { boxShadow: '0 0 40px rgba(30,58,138,0.7)' } }
                }
            }
        }
    }
</script>

<div class="min-h-screen bg-gradient-to-br from-light via-white to-indigo-50 font-raleway">

    <!-- Title -->
    <div class="text-center py-16 px-6">
        <h1 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary animate-fadeIn">
            {{ $course->title }}
        </h1>
        <p class="mt-6 text-xl text-gray-700 font-medium">
            by <span class="font-bold text-primary">{{ $course->teacher->name ?? 'Expert' }}</span>
            • {{ $course->company->name ?? 'Code IT Nepal' }}
        </p>
    </div>

    <!-- MAIN LAYOUT: 60% LEFT + 40% RIGHT -->
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- LEFT SECTION: 60% WIDTH -->
            <div class="lg:col-span-7 animate-fadeIn">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden h-full flex flex-col">
                    <div class="bg-gradient-to-r from-primary to-indigo-700 text-white p-8 text-center">
                        <i class="fa-solid fa-book-open-reader text-5xl mb-4 animate-float"></i>
                        <h3 class="text-2xl font-bold">Course Syllabus</h3>
                    </div>
                    <div class="p-8 lg:p-10 prose prose-lg max-w-none flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-primary/40">
                        {!! $course->syllabus ?? '<div class="text-center py-24 text-gray-400"><i class="fa-solid fa-clock text-7xl mb-6"></i><p class="text-xl italic">Syllabus will be updated soon</p></div>' !!}
                    </div>
                </div>
            </div>

            <!-- RIGHT SECTION: 40% WIDTH -->
            <div class="lg:col-span-5 animate-fadeIn animation-delay-300">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-10 h-full flex flex-col justify-between">
                    <div class="text-center space-y-10">

                        <!-- Price -->
                        @if($course->active_discount)
                            <div>
                                <p class="text-6xl lg:text-7xl font-black text-secondary">NPR {{ number_format($course->discounted_price_npr) }}</p>
                                <p class="text-3xl text-gray-400 line-through mt-2">NPR {{ number_format($course->original_price_npr) }}</p>
                                <div class="mt-6 inline-block px-8 py-4 bg-red-600 text-white rounded-full font-bold text-lg shadow-lg animate-pulse">
                                    {{ $course->discount_percentage_active }}% OFF – Limited Offer
                                </div>
                            </div>
                        @else
                            <p class="text-6xl lg:text-7xl font-black text-primary">NPR {{ number_format($course->discounted_price_npr) }}</p>
                        @endif

                        <!-- Info -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-primary/5 p-6 rounded-2xl text-center border border-primary/10">
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Start Date</p>
                                <p class="text-2xl font-black text-primary mt-2">{{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }}</p>
                            </div>
                            <div class="bg-secondary/5 p-6 rounded-2xl text-center border border-secondary/10">
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Duration</p>
                                <p class="text-2xl font-black text-secondary mt-2">{{ $course->duration_days }} Days</p>
                            </div>
                        </div>

                        <!-- Seats -->
                        <div class="py-6">
                            <p class="text-2xl font-bold text-red-600">
                                Only {{ $course->available_seats }} Seats Left
                            </p>
                        </div>

                        <!-- ENROLL BUTTON (Full width in 40% section) -->
                        @if($course->available_seats > 0 && $course->active_status === 'active')
                            <button onclick="openEnrollmentModal()"
                                    class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-indigo-800 hover:to-primary text-white font-black text-2xl lg:text-3xl py-10 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-5 group animate-glow">
                                <i class="fa-solid fa-graduation-cap text-5xl group-hover:rotate-12 transition"></i>
                                ENROLL NOW
                                <i class="fa-solid fa-arrow-right text-4xl group-hover:translate-x-4 transition"></i>
                            </button>
                        @else
                            <div class="w-full bg-gray-200 text-gray-600 font-bold text-2xl py-10 rounded-2xl text-center">
                                Enrollment Closed
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ENROLLMENT MODAL (Same as before – Professional & Clean) -->
    <div id="enrollmentModal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[9999] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-3xl max-w-3xl w-full max-h-[95vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary to-indigo-800 text-white p-10 text-center relative">
                <button onclick="closeModal()" class="absolute top-6 right-8 text-white text-4xl hover:scale-125 transition">×</button>
                <h2 class="text-4xl font-black">Complete Enrollment</h2>
                <p class="mt-3 text-xl">{{ $course->title }}</p>
                <p class="mt-4 text-3xl font-black text-secondary">NPR {{ number_format($course->discounted_price_npr) }}</p>
            </div>

            <form id="enrollForm" class="p-10 space-y-8" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label><input type="text" name="full_name" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-lg"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Email *</label><input type="email" name="email" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-lg"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Phone *</label><input type="tel" name="phone" required placeholder="+977..." class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-lg"></div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Transaction ID *</label><input type="text" name="reference_code" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-lg"></div>
                </div>

                <div><label class="block text-sm font-bold text-gray-700 mb-2">Payment Method *</label>
                    <select name="payment_method_id" required class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition text-lg" onchange="showPaymentInfo(this)">
                        <option value="">-- Select Method --</option>
                        @foreach($payment_methods as $m)
                            <option value="{{ $m->id }}" data-qr="{{ $m->qr_code ? Storage::url($m->qr_code) : '' }}" data-number="{{ $m->account_number }}">{{ $m->method_name }} – {{ $m->account_holder }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="paymentInfo" class="hidden bg-gray-50 p-8 rounded-2xl border-2 border-dashed border-primary/30 text-center">
                    <img id="qrImage" src="" alt="QR" class="mx-auto w-64 h-64 rounded-xl shadow-xl mb-6 hidden">
                    <div id="accountDetails" class="text-lg font-bold text-primary"></div>
                </div>

                <div><label class="block text-sm font-bold text-gray-700 mb-3">Payment Screenshot *</label>
                    <div class="border-4 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-primary transition cursor-pointer">
                        <input type="file" name="screenshot" required accept="image/*" class="hidden" id="screenshot" onchange="previewImg(this)">
                        <i class="fa-solid fa-cloud-arrow-up text-6xl text-gray-400 mb-4"></i>
                        <p class="text-lg font-semibold">Click to upload</p>
                        <p class="text-sm text-gray-500">JPG/PNG • Max 5MB</p>
                        <div id="preview" class="mt-6 hidden"><img src="" alt="Preview" class="mx-auto max-h-80 rounded-xl shadow-xl"></div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-indigo-800 hover:from-secondary hover:to-orange-600 text-white font-black text-2xl py-8 rounded-2xl shadow-2xl transform hover:scale-105 transition-all flex items-center justify-center gap-4">
                    <i class="fa-solid fa-check-circle text-3xl"></i>
                    SUBMIT ENROLLMENT
                </button>
            </form>

            <div id="successBox" class="hidden p-16 text-center bg-gradient-to-b from-green-50 to-white">
                <i class="fa-solid fa-circle-check text-9xl text-green-600 mb-8 animate-bounce"></i>
                <h3 class="text-4xl font-black text-primary mb-6">Enrollment Successful!</h3>
                <p class="text-xl mb-6">Your password:</p>
                <code id="passwordDisplay" class="bg-gray-100 px-12 py-8 rounded-2xl text-4xl font-black text-secondary tracking-wider"></code>
            </div>
        </div>
    </div>
</div>

<style>
.scrollbar-thin::-webkit-scrollbar { width: 8px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #1E3A8A; border-radius: 10px; }
.animation-delay-300 { animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards; }
</style>

<!-- Same JS as before -->
<script>
// ... (same openModal, closeModal, showPaymentInfo, previewImg, form submit)
</script>

<x-frontend-footer />
</x-frontend-layout>

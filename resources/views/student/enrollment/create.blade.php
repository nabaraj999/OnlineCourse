{{-- resources/views/enrollment/create.blade.php --}}

<x-student-layout title="Enroll in {{ $course->title }}">

<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-10 text-center">
            <h1 class="text-4xl font-bold">Complete Your Enrollment</h1>
            <p class="mt-3 text-xl opacity-90">You're one step away from joining</p>
        </div>

        <div class="p-10">
            <!-- Course Summary -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-8 mb-10 text-center">
                <h2 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h2>
                <p class="text-5xl font-extrabold text-primary mt-4">
                    Rs. {{ number_format($course->price) }}
                </p>
                <p class="text-gray-600 mt-2">One-time payment • Instant access after approval</p>
            </div>

            <form action="{{ route('enroll.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <!-- Student Info (Auto-filled & Readonly) -->
                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Your Information (Auto-filled)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text"
                                   value="{{ auth()->user()->full_name ?? '' }}"
                                   class="w-full px-5 py-4 bg-gray-100 border border-gray-300 rounded-xl cursor-not-allowed"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email"
                                   value="{{ auth()->user()->email ?? '' }}"
                                   class="w-full px-5 py-4 bg-gray-100 border border-gray-300 rounded-xl cursor-not-allowed"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="text"
                                   value="{{ auth()->user()->phone ?? '' }}"
                                   class="w-full px-5 py-4 bg-gray-100 border border-gray-300 rounded-xl cursor-not-allowed"
                                   readonly>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields for backend (still sent) -->
                <input type="hidden" name="full_name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">

                <!-- Payment Method -->
                <div>
                    <label class="block text-lg font-bold text-gray-800 mb-4">Choose Payment Method</label>
                    <select name="payment_method_id" class="w-full px-6 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-primary focus:outline-none" required>
                        <option value="">-- Select Payment Method --</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->method_name }} - {{ $method->account_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Upload Screenshot -->
                <div>
                    <label class="block text-lg font-bold text-gray-800 mb-4">Upload Payment Screenshot</label>
                    <input type="file"
                           name="screenshot"
                           accept="image/*"
                           class="block w-full text-lg file:mr-4 file:py-4 file:px-8 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-indigo-700"
                           required>
                    <p class="text-sm text-gray-500 mt-3">Supported: JPG, PNG, WebP • Max 2MB</p>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold text-xl py-6 rounded-2xl hover:from-indigo-700 hover:to-purple-800 transform hover:scale-105 transition duration-300 shadow-xl">
                    Submit Enrollment Request
                </button>
            </form>

            <!-- Payment QR Codes – Click to enlarge -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Pay Using These QR Codes</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($paymentMethods as $method)
                        @if($method->qr_code)
                            <div class="text-center group cursor-pointer" onclick="openModal('{{ asset('storage/' . $method->qr_code) }}', '{{ $method->method_name }}')">
                                <img src="{{ asset('storage/' . $method->qr_code) }}"
                                     alt="{{ $method->method_name }}"
                                     class="w-32 h-32 mx-auto rounded-2xl shadow-lg border-4 border-white group-hover:scale-110 group-hover:shadow-2xl transition duration-300">
                                <p class="mt-4 font-semibold text-gray-700">{{ $method->method_name }}</p>
                                <p class="text-sm text-gray-500">{{ $method->account_number }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Full Size QR -->
<div id="qrModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 p-4" onclick="closeModal()">
    <div class="relative max-w-lg w-full">
        <img id="modalImage" src="" alt="" class="w-full rounded-2xl shadow-2xl">
        <p id="modalTitle" class="text-center text-white text-xl font-bold mt-6"></p>
        <button class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300">&times;</button>
    </div>
</div>

<script>
function openModal(imageUrl, title) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('qrModal').classList.remove('hidden');
    document.getElementById('qrModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('qrModal').classList.add('hidden');
    document.getElementById('qrModal').classList.remove('flex');
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>

</x-student-layout>

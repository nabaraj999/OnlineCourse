{{-- resources/views/student/certificates/index.blade.php --}}
<x-student-layout title="My Certificates">

<div class="max-w-5xl mx-auto py-12 px-6">
    <h1 class="text-4xl font-bold text-center text-primary mb-10">My Certificates</h1>

    @forelse($certificates as $cert)
        @php
            $student = $cert->enrollment;
            $course = $cert->enrollment->course;
        @endphp

        <div class="bg-white rounded-2xl shadow-xl border overflow-hidden mb-8 hover:shadow-2xl transition">
            <div class="md:flex">
                <!-- Certificate Preview -->
                <div class="md:w-8/12 bg-gradient-to-r from-indigo-900 to-blue-900 p-10 text-white">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold text-yellow-400 mb-4">CERTIFICATE</h2>
                        <p class="text-lg mb-8">of Completion</p>

                        <h3 class="text-5xl font-bold text-yellow-300 my-8">
                            {{ $student->full_name }}
                        </h3>

                        <div class="bg-white bg-opacity-20 rounded-xl py-6 px-10 inline-block">
                            <h4 class="text-3xl font-bold">{{ $course->title }}</h4>
                            <p class="text-lg mt-3">
                                Issued on {{ $cert->issued_at->format('d F Y') }}
                            </p>
                        </div>

                        <p class="mt-8 text-sm opacity-90">
                            Certificate No: <span class="font-bold">{{ $cert->certificate_number }}</span>
                        </p>
                    </div>
                </div>

                <!-- Download Button -->
                <div class="md:w-4/12 bg-gray-50 p-10 flex flex-col justify-center items-center">
                    <img src="{{ asset('images/logo.png') }}" class="h-20 mb-6">

                    <a href="{{ route('certificate.download', $cert->id) }}"
                       class="bg-green-600 hover:bg-green-700 text-white font-bold text-xl px-10 py-5 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center space-x-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Download PDF</span>
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div class="text-center py-20">
            <h3 class="text-3xl font-bold text-gray-600">No Certificates Yet</h3>
            <p class="text-lg text-gray-500 mt-4">Complete your courses to earn certificates!</p>
        </div>
    @endforelse
</div>

</x-student-layout>

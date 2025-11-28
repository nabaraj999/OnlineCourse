<!-- resources/views/student/certificates/index.blade.php -->
<x-student-layout title="My Certificates">

<div class="max-w-6xl mx-auto py-10 px-6 font-raleway">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-primary mb-4">My Certificates</h1>
        <p class="text-lg text-gray-600">View and download your earned certificates</p>
    </div>

    @if($certificates->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($certificates as $cert)
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-primary to-indigo-800 text-white p-6 text-center">
                        <i class="fas fa-award text-5xl mb-3"></i>
                        <h3 class="text-xl font-bold">Certificate of Completion</h3>
                        <p class="text-sm opacity-90 mt-2">#{{ $cert->certificate_number }}</p>
                    </div>
                    <div class="p-6">
                        <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ $cert->course->title }}</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Student:</strong> {{ $cert->enrollment->full_name }}</p>
                            <p><strong>Issued:</strong> {{ $cert->issued_at->format('d M Y') }}</p>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('certificate.download', $cert->id) }}"
                               class="flex-1 bg-primary text-white text-center py-3 rounded-lg hover:bg-indigo-800 transition font-bold">
                                Download PDF
                            </a>
                            <button onclick="viewCertificate({{ $cert->id }})"
                                    class="flex-1 border-2 border-primary text-primary py-3 rounded-lg hover:bg-primary hover:text-white transition font-bold">
                                View
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-xl border border-gray-200">
            <i class="fas fa-certificate text-8xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">No Certificates Yet</h3>
            <p class="text-gray-600 text-lg">Complete your enrolled courses to earn certificates!</p>
        </div>
    @endif

    <!-- Enrolled Courses (Pending Certificates) -->
    @if($enrolledCourses->where('pivot.status', 'approved')->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-primary mb-8 text-center">Enrolled Courses</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($enrolledCourses as $course)
                    @php
                        $hasCert = $certificates->where('course_id', $course->id)->first();
                    @endphp
                    <div class="bg-white rounded-xl shadow-lg border p-6 flex items-center justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $course->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">Enrolled: {{ $course->pivot->enrolled_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            @if($hasCert && $hasCert->is_issued)
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                                    Certificate Issued
                                </span>
                            @else
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold">
                                    In Progress
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

</x-student-layout>

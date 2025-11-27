<x-student-layout title="My Courses">

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Courses</h1>
            <p class="mt-2 text-gray-600">Track your learning journey and continue where you left off.</p>
        </div>

        @if($enrollments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($enrollments as $enrollment)
                    @php
                        $course = $enrollment->course;
                        $progress = $enrollment->progress ?? 0; // make sure you have progress column or calculate it
                    @endphp

                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <!-- Course Image -->
                        <div class="relative h-48">
                         <img src="{{ $course->photo ? asset('storage/' . $course->photo) : asset('images/default-course.jpg') }}"
     alt="{{ $course->title }}"
     class="w-full h-48 object-cover rounded-t-2xl">
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                             bg-green-100 text-green-800 border border-green-300">
                                    Enrolled
                                </span>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $course->title }}
                            </h3>

                            <!-- Dates -->
                            <div class="space-y-2 text-sm text-gray-600 mb-5">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Started: {{ $course->start_date?->format('d M Y') ?? 'Self-paced' }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Ends: {{ $course->end_date?->format('d M Y') ?? 'No deadline' }}</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">Progress</span>
                                    <span class="text-primary font-semibold">{{ number_format($progress) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-primary h-3 rounded-full transition-all duration-500"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="#"
                               class="block w-full text-center mt-5 px-5 py-3 bg-primary text-white font-medium rounded-lg
                                      hover:bg-indigo-700 transition shadow-md">
                                Continue Learning
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl shadow-md border border-gray-100">
                <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No courses yet</h3>
                <p class="text-gray-600 mb-6">Enroll in a course to start learning!</p>
                <a href="{{ route('student.enroll') }}"
                   class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                    Browse Courses
                </a>
            </div>
        @endif
    </div>

</x-student-layout>

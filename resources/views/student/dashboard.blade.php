{{-- resources/views/student/dashboard.blade.php --}}

<x-student-layout title="Dashboard">

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $student->name }}!</h1>
            <p class="mt-2 text-gray-600">Here's your learning overview</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Enrolled Courses -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100">Enrolled Courses</p>
                        <p class="text-4xl font-bold mt-2">{{ $enrolledCoursesCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>

            <!-- Pending Approval -->
            <div class="bg-gradient-to-br from-yellow-500 to-amber-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100">Pending Approval</p>
                        <p class="text-4xl font-bold mt-2">
                            {{ \App\Models\Enrollment::where('email', $student->email)->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100">Available to Join</p>
                        <p class="text-4xl font-bold mt-2">{{ $availableCourses->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100">Total Spent</p>
                        <p class="text-4xl font-bold mt-2">
                            Rs. {{ number_format(\App\Models\Enrollment::where('email', $student->email)->where('status', 'approved')->sum('amount_paid')) }}
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Recent Activity -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
                    <ul class="space-y-3">
                        @forelse($recentActivities as $activity)
                            <li class="flex items-center text-sm">
                                <span class="w-3 h-3 {{ $activity['color'] }} rounded-full mr-3 flex-shrink-0"></span>
                                <span class="flex-1">{!! $activity['message'] !!}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $activity['time'] }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500 italic">No activity yet</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Available Courses → Now links directly to Enrollment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Available Courses to Enroll</h3>
                        <a href="{{ route('courses.index') ?? '#' }}" class="text-primary hover:underline text-sm font-medium">
                            Browse All →
                        </a>
                    </div>

                    @if($availableCourses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($availableCourses as $course)
                                <a href="{{ route('enroll.form', $course->slug) }}"
                                   class="block p-5 bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 rounded-xl border border-indigo-200 transition transform hover:scale-105">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $course->title }}</h4>
                                        <span class="text-xs bg-green-100 text-green-800 px-3 py-100 py-1 rounded-full">New</span>
                                    </div>
                                    <p class="text-sm text-gray-600">by {{ $course->teacher?->name ?? 'Instructor' }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-2xl font-bold text-primary">Rs. {{ number_format($course->price) }}</span>
                                        <span class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium">
                                            Enroll Now
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center py-10 text-gray-500">No new courses available right now. Check back later!</p>
                    @endif
                </div>
            </div>

        </div>
        <!-- Payment Methods section REMOVED as requested -->

    </div>
</x-student-layout>

<x-student-layout title="Dashboard">

     <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <nav class="flex text-sm text-gray-500 mt-2">
                        <a href="#" class="hover:text-primary">Home</a>
                        <span class="mx-2">/</span>
                        <a href="#" class="hover:text-primary">Student Panel</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Dashboard</span>
                    </nav>
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Enrolled Courses (Dynamic) -->
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Enrolled Courses</h3>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ $enrolledCoursesCount }}</p>
                        <p class="text-gray-600">Active approved courses</p>
                    </div>

                    <!-- Recent Activity (Dynamic) -->
                    <div
                        class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 md:col-span-2 lg:col-span-1">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                        <ul class="space-y-3">
                            @forelse($recentActivities as $activity)
                                <li class="flex items-center text-sm">
                                    <span class="w-2 h-2 {{ $activity['color'] }} rounded-full mr-3"></span>
                                    <span class="flex-1">{!! $activity['message'] !!}</span>
                                    <span class="ml-auto text-gray-500 text-xs">{{ $activity['time'] }}</span>
                                </li>
                            @empty
                                <li class="text-gray-500 text-sm italic">No recent activity</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- You can keep other cards static or make them dynamic later -->
                    <!-- Example: Assignments Due, GPA, Upcoming Events, Quick Actions -->

                </div>

</x-student-layout>

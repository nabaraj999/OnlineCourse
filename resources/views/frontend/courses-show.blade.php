<x-frontend-layout />
<section id="course-details" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary md:text-4xl">{{ $course->title }}</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Explore the details of this course and start your learning journey
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 mt-8" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Side: Course Syllabus -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 md:text-3xl">Course Syllabus</h3>
                <div class="text-gray-600 prose prose-sm max-w-none prose-headings:text-gray-800 prose-headings:font-semibold prose-p:my-3 prose-ul:my-3 prose-li:my-2 space-y-4">
                    {!! $course->syllabus ?? 'No syllabus provided.' !!}
                </div>
            </div>

            <!-- Right Side: Course Photo, Details & Info -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 p-6 space-y-6">
                <!-- Course Photo -->
                <div class="w-full h-64 md:h-72 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                        class="w-full h-full object-cover" onerror="this.src='/images/placeholder.jpg';">
                </div>

                <!-- Price and Discount -->
                <div class="p-4 bg-gray-50 rounded-lg shadow-inner">
                    <span class="text-xl font-semibold text-green-600 md:text-2xl">NPR {{ number_format($course->discounted_price_npr, 2) }}</span>
                    @if ($course->active_status === 'active' &&
                        $course->discount_percentage > 0 &&
                        Carbon\Carbon::now()->setTimezone('Asia/Kathmandu')->between(
                            Carbon\Carbon::parse($course->discount_valid_from),
                            Carbon\Carbon::parse($course->discount_valid_to)))
                        <span class="block text-sm font-medium text-gray-500 line-through mt-1">NPR {{ number_format($course->original_price_npr, 2) }}</span>
                        <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ $course->discount_percentage }}% Off <i class="fa-solid fa-tags ml-1"></i>
                        </span>
                    @endif
                </div>

                <!-- Additional Details -->
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="flex items-center"><i class="fa-solid fa-calendar-day mr-2 text-primary"></i> <strong>Start Date:</strong> {{ $course->start_date ? Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}</p>
                    <p class="flex items-center"><i class="fa-solid fa-clock mr-2 text-primary"></i> <strong>Duration:</strong> {{ $course->duration_days }} days</p>
                    <p class="flex items-center"><i class="fa-solid fa-chair mr-2 text-primary"></i> <strong>Available Seats:</strong> {{ $course->available_seats }} seats left</p>
                </div>

                <!-- Enroll the Course Section -->
                <div class="space-y-4">
                    <a href="{{ route('courses_enroll', $course->id) }}"
                       class="inline-block w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg">
                        Enroll Now <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>

                    <a href="#" class="inline-block w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-medium text-center transition duration-300 shadow-md hover:shadow-lg">
                        Watch Demo Video <i class="fa-solid fa-play ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-primary rounded-lg font-medium transition duration-300 shadow-md hover:shadow-lg">
                Back to All Courses
                <i class="fa-solid fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>
</section>
<x-frontend-footer />

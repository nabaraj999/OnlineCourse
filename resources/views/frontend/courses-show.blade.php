<x-frontend-layout />
<section id="course-details" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary">{{ $course->title }}</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Explore the details of this course and start your learning journey
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mt-12 bg-white rounded-xl overflow-hidden shadow-md border border-gray-100">
            <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                class="w-full h-64 object-cover bg-gray-200" onerror="this.src='/images/placeholder.jpg';">
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                    <div class="md:w-2/3">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $course->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $course->syllabus }}</p>
                        <div class="text-sm text-gray-500 mb-4">
                            <p><strong>Teacher:</strong> {{ $course->teacher->name ?? 'N/A' }}</p>
                            <p><strong>Company:</strong> {{ $course->company->name ?? 'N/A' }}</p>
                            <p><strong>Duration:</strong> {{ $course->duration_days }} days</p>
                            <p><strong>Available Seats:</strong> {{ $course->available_seats }} seats left</p>
                            <p><strong>Start Date:</strong> {{ $course->start_date ? Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}</p>
                            <p><strong>Rating:</strong> {{ $course->rating }} ★</p>
                        </div>
                    </div>
                    <div class="md:w-1/3 text-center md:text-right">
                        <div class="mb-4">
                            <span class="text-lg font-semibold text-green-600">NPR {{ number_format($course->discounted_price_npr, 2) }}</span>
                            @if ($course->active_status === 'active' &&
                                $course->discount_percentage > 0 &&
                                Carbon\Carbon::now()->setTimezone('Asia/Kathmandu')->between(
                                    Carbon\Carbon::parse($course->discount_valid_from),
                                    Carbon\Carbon::parse($course->discount_valid_to)))
                                <span class="block text-sm font-medium text-gray-500 line-through">NPR {{ number_format($course->original_price_npr, 2) }}</span>
                                <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-medium bg-secondary-100 text-blue-800">
                                    {{ $course->discount_percentage }}% Off
                                </span>
                            @endif
                        </div>
                        <a href="#" class="inline-block w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-medium transition duration-300">
                            Enroll Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center px-4 py-2 bg-secondary-100 hover:bg-secondary-200 text-primary rounded-lg font-medium transition duration-300">
                Back to All Courses
                <i class="fa-solid fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>
</section>
<x-frontend-footer />

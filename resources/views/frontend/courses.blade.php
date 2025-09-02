<x-frontend-layout />
<section id="courses" class="py-16 bg-primary bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary">Popular Courses</h2>
            <p class="mt-4 text-lg text-primary max-w-3xl mx-auto">
                Discover our most popular courses designed to help you achieve your career goals
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($courses as $course)
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <img src="{{ Storage::url($course->photo) }}" alt="{{ $course->title }}"
                        class="w-full h-48 object-cover bg-gray-200" onerror="this.src='/images/placeholder.jpg';">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary-100 text-blue-800">{{ $course->rating }}
                                ★</span>
                            <span class="text-lg font-semibold text-green-600">NPR
                                {{ number_format($course->discounted_price_npr, 2) }}</span>
                            @if (
                                $course->active_status === 'active' &&
                                    $course->discount_percentage > 0 &&
                                    Carbon\Carbon::now()->setTimezone('Asia/Kathmandu')->between(
                                            Carbon\Carbon::parse($course->discount_valid_from),
                                            Carbon\Carbon::parse($course->discount_valid_to)))
                                <span class="text-sm font-medium text-gray-500 line-through">NPR
                                    {{ number_format($course->original_price_npr, 2) }}</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 line-clamp-2">{{ $course->title }}</h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $course->syllabus }}</p>
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <span class="flex items-center"><i class="fa-regular fa-clock mr-1"></i>
                                {{ $course->duration_days }} days</span>
                            <span class="flex items-center"><i class="fa-solid fa-chair mr-1"></i>
                                {{ $course->available_seats }} seats left</span>
                        </div>
                        <a href="{{ route('courses.show', $course->id) }}"
                            class="mt-5 inline-block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-medium transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">No active courses available at the moment.</p>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center px-4 py-2 bg-secondary-100 hover:bg-secondary-200 text-primary rounded-lg font-medium transition duration-300">
                View All Courses
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
<x-frontend-footer />

{{-- resources/views/student/course-detail.blade.php --}}

<x-student-layout :title="$course->title">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">{{ $course->title }}</h1>
            <p class="mt-2 text-lg text-gray-600">Course Materials & Resources</p>
        </div>

        <!-- Course Info Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Start Date</p>
                    <p class="text-lg font-semibold">{{ $course->start_date?->format('d M Y') ?? 'Self-paced' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Teacher</p>
                    <p class="text-lg font-semibold">{{ $course->teacher?->name ?? 'Not assigned' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Materials</p>
                    <p class="text-lg font-semibold">{{ $materials->count() }} resources</p>
                </div>
            </div>
        </div>

        <!-- Materials List -->
        @if ($materials->count() > 0)
            <div class="space-y-4">
                @foreach ($materials as $material)
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Type Badge + Title -->
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
    {{ $material->type === 'video'
        ? 'bg-purple-100 text-purple-800'
        : ($material->type === 'pdf'
            ? 'bg-red-100 text-red-800'
            : ($material->type === 'ppt'
                ? 'bg-orange-100 text-orange-800'
                : ($material->type === 'assignment'
                    ? 'bg-blue-100 text-blue-800'
                    : 'bg-gray-100 text-gray-800'))) }}">
                                            {{ ucfirst($material->type) }}
                                        </span>
                                        <h3 class="text-xl font-bold text-gray-900">
                                            {{ $material->title }}
                                        </h3>
                                    </div>

                                    <!-- Date & Description -->
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        @if ($material->resource_date)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $material->resource_date->format('d M Y') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($material->description)
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            {{ Str::limit($material->description, 200) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="ml-6">
                                    @if ($material->file_path)
                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                            class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-md">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download / View
                                        </a>
                                    @elseif($material->external_url)
                                        <a href="{{ $material->external_url }}" target="_blank"
                                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-md">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            Open Link
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                <svg class="mx-auto h-20 w-20 text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No materials yet</h3>
                <p class="text-gray-600">Your teacher will upload course materials soon.</p>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('student.my-courses') }}" class="text-primary hover:underline font-medium">
                ← Back to My Courses
            </a>
        </div>
    </div>

</x-student-layout>

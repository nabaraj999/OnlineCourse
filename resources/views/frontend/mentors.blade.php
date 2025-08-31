<x-frontend-layout />


       <section id="mentors" class="py-10 bg-light font-raleway sm:py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-primary sm:text-3xl md:text-4xl">Meet Our Mentors</h2>
            <p class="mt-3 text-base text-gray-600 max-w-2xl mx-auto sm:text-lg">
                Learn from industry experts with years of proven experience
            </p>
        </div>

        <!-- Cards -->
        <div class="mt-8 grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            @forelse ($teachers as $teacher)
                <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-transform duration-500 sm:hover:-translate-y-3 sm:hover:scale-[1.02] border border-light">
                    <!-- Full Cover Image -->
                    <div class="relative h-48 w-full sm:h-56">
                        @if ($teacher->logo)
                            <img src="{{ Storage::url($teacher->logo) }}" alt="{{ $teacher->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-primary flex items-center justify-center">
                                <i class="fa-solid fa-user-tie text-white text-5xl sm:text-6xl"></i>
                            </div>
                        @endif
                        <!-- Hover Overlay (Disabled on Mobile) -->
                        <div class="absolute inset-0 bg-primary bg-opacity-70 flex items-center justify-center opacity-0 sm:group-hover:opacity-100 transition-opacity duration-500">
                            <div class="flex space-x-4">
                                <a href="#" class="p-2 rounded-full border-2 border-white text-white hover:bg-secondary hover:border-secondary transition sm:p-3">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                                <a href="mailto:{{ $teacher->email }}" class="p-2 rounded-full border-2 border-white text-white hover:bg-secondary hover:border-secondary transition sm:p-3">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 text-center sm:p-6">
                        <!-- Subject -->
                        <p class="text-secondary font-semibold uppercase tracking-wide text-xs sm:text-sm">
                            {{ $teacher->subject ?? 'Expert' }}
                        </p>

                        <!-- Name -->
                        <h2 class="text-lg font-bold text-primary sm:text-2xl">
                            {{ $teacher->name }}
                        </h2>

                        <!-- Address -->
                        <p class="text-gray-600 text-xs sm:text-sm">
                            {{ $teacher->address ?? 'Location not specified' }}
                        </p>

                        <!-- Experience -->
                        <p class="text-gray-500 text-xs italic sm:text-sm">
                            {{ $teacher->experience ?? 'Experienced Professional' }}
                        </p>
                    </div>

                    <!-- Bottom Accent -->
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-secondary"></div>
                </div>
            @empty
                <p class="text-center text-gray-600 text-sm col-span-full sm:text-base">No active mentors available at this time.</p>
            @endforelse
        </div>
    </div>
</section>


<x-frontend-footer />

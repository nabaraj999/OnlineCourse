   <x-frontend-layout />
       <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
   <section id="courses" class="py-16 bg-primary bg-opacity-5">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="text-center">
               <h2 class="text-3xl font-bold text-white">Popular Courses</h2>
               <p class="mt-4 text-lg text-white max-w-3xl mx-auto">
                   Discover our most popular courses designed to help you achieve your career goals
               </p>
           </div>

           <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
               @forelse ($courses as $course)
                   <div
                       class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border">
                       <img src="{{ $course->photo_path }}" alt="{{ $course->title }}" class="w-full h-52 object-cover">

                       <div class="p-6">
                           <div class="flex items-center justify-between mb-3">
                               <span
                                   class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                   {{ $course->rating ?? '0.0' }} ★
                               </span>

                               <div class="text-right">
                                   <span class="text-2xl font-bold text-green-600">
                                       NPR {{ number_format($course->discounted_price_npr, 0) }}
                                   </span>
                                   @if ($course->active_discount)
                                       <span class="block text-sm text-gray-500 line-through">
                                           NPR {{ number_format($course->original_price_npr, 0) }}
                                       </span>
                                       <span class="text-xs bg-red-600 text-white px-2 py-1 rounded">
                                           {{ $course->discount_percentage_active }}% OFF
                                       </span>
                                   @endif
                               </div>
                           </div>

                           <h3 class="text-xl font-bold text-gray-900 mt-3 line-clamp-2">
                               {{ $course->title }}
                           </h3>

                           <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                               <span><i class="fa-regular fa-clock mr-2"></i>{{ $course->duration_days }} days</span>
                               <span><i class="fa-solid fa-users mr-2"></i>{{ $course->available_seats }} seats
                                   left</span>
                           </div>

                           <div class="mt-6">
                               @if ($course->available_seats > 0)
                                   <a href="{{ route('courses.show', $course->slug) }}"
                                       class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
                                       View Details & Enroll
                                   </a>
                               @else
                                   <button disabled
                                       class="w-full bg-gray-400 text-white font-semibold py-3 rounded-lg cursor-not-allowed">
                                       Fully Booked
                                   </button>
                               @endif
                           </div>
                       </div>
                   </div>
               @empty
                   <div class="col-span-full text-center py-12">
                       <p class="text-xl text-gray-600">No active courses available at the moment.</p>
                   </div>
               @endforelse
           </div>

           <div class="mt-12 text-center">
               <a href="{{ route('courses.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                   View All Courses
                   <i class="fa-solid fa-arrow-right ml-3"></i>
               </a>
           </div>
       </div>
   </section>

   <x-frontend-footer />

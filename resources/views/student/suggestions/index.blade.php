<x-student-layout title="Suggestions & Feedback">

<div class="max-w-5xl mx-auto py-10 px-6 font-raleway">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-4">Suggestions & Feedback</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Your voice matters. Help us make the platform better for everyone.
        </p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-sm">
            <i class="fas fa-check-circle text-2xl mr-3"></i>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
            <button type="button" class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-lightbulb text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Submit New Suggestion</h3>
                </div>

                <form action="{{ route('student.suggestions.store') }}" method="POST" class="space-y-7">
                    @csrf

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-5 py-4 rounded-xl border-2 @error('subject') border-red-500 @else border-gray-300 @enderror focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                               placeholder="e.g., Login button not working on mobile">
                        @error('subject')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">
                            Your Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="7" required
                                  class="w-full px-5 py-4 rounded-xl border-2 @error('message') border-red-500 @else border-gray-300 @enderror focus:border-primary focus:ring-4 focus:ring-primary/20 transition resize-none"
                                  placeholder="Describe your suggestion or issue in detail... (steps to reproduce, device, browser, etc.)">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-primary hover:bg-indigo-800 text-white font-bold py-5 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 text-lg flex items-center justify-center space-x-3">
                            <i class="fas fa-paper-plane"></i>
                            <span>Submit Suggestion</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stats -->
            <div class="bg-primary text-white rounded-2xl p-7 shadow-xl">
                <h4 class="text-xl font-bold mb-6">Your Activity</h4>
                <div class="space-y-4 text-lg">
                    <div class="flex justify-between">
                        <span>Total Sent</span>
                        <strong>{{ $suggestions->total() }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Resolved</span>
                        <strong class="text-secondary">{{ $suggestions->where('status', 'resolved')->count() }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Pending</span>
                        <strong>{{ $suggestions->where('status', 'pending')->count() }}</strong>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-amber-50 border-2 border-secondary/30 rounded-2xl p-6">
                <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-star text-secondary mr-2"></i> Quick Tips
                </h4>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li>• One issue per suggestion</li>
                    <li>• Include device & browser</li>
                    <li>• We reply within 24–48 hours</li>
                    <li>• You’re helping everyone!</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Previous Suggestions -->
    @if($suggestions->count() > 0)
        <div class="mt-12 bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-primary text-white p-7">
                <h3 class="text-2xl font-bold">Your Previous Suggestions</h3>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($suggestions as $suggestion)
                    <div class="p-7 hover:bg-light transition {{ $suggestion->admin_reply ? 'bg-emerald-50 border-l-4 border-emerald-500' : '' }}">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-bold text-gray-900 text-lg">{{ $suggestion->subject }}</h4>
                            {!! $suggestion->status_badge !!}
                        </div>

                        <p class="text-gray-700 mb-5 leading-relaxed">{{ $suggestion->message }}</p>

                        <div class="text-sm text-gray-500 space-y-3">
                            <div class="flex items-center space-x-4">
                                <span><i class="fas fa-clock mr-1"></i> {{ $suggestion->submitted_at }}</span>
                                @if($suggestion->admin_reply)
                                    <span class="text-emerald-600 font-bold">
                                        <i class="fas fa-reply mr-1"></i> Replied by Admin
                                    </span>
                                @endif
                            </div>

                            @if($suggestion->admin_reply)
                                <div class="mt-4 p-5 bg-white rounded-xl border border-emerald-300 shadow">
                                    <p class="font-bold text-emerald-700 mb-2">Admin Reply:</p>
                                    <p class="text-gray-800">{{ $suggestion->admin_reply }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6 bg-light border-t">
                {{ $suggestions->links('pagination::tailwind') }}
            </div>
        </div>
    @else
        <div class="mt-12 text-center py-20 bg-white rounded-2xl shadow-xl border border-gray-200">
            <div class="w-28 h-28 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-comment-medical text-5xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">No suggestions yet</h3>
            <p class="text-gray-600 text-lg">Be the first to share your thoughts!</p>
        </div>
    @endif
</div>

</x-student-layout>

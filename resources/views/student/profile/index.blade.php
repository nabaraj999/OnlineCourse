<!-- resources/views/student/profile/index.blade.php -->
<x-student-layout title="My Profile">

<div class="max-w-5xl mx-auto py-10 px-6 font-raleway">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-primary mb-3">My Profile</h1>
        <p class="text-gray-600">Manage your personal information and account settings</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-300 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-sm">
            <i class="fas fa-check-circle text-2xl mr-3"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 text-center">
                <div class="w-32 h-32 mx-auto mb-6 bg-primary rounded-full flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                    {{ strtoupper(substr($student->full_name, 0, 2)) }}
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                <p class="text-gray-600 mt-2">{{ $student->email }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $student->phone }}</p>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="space-y-4 text-left">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Status</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $student->status === 'approved' ? 'bg-green-100 text-green-800' :
                                   ($student->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium">{{ $student->enrolled_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-user-edit text-primary mr-3"></i>
                    Edit Profile Information
                </h3>

                <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-7">
                    @csrf
                    @method('PATCH')

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" required
                                   class="w-full px-5 py-4 rounded-xl border-2 @error('full_name') border-red-500 @else border-gray-300 @enderror focus:border-primary focus:ring-4 focus:ring-primary/20 transition">
                            @error('full_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                                   class="w-full px-5 py-4 rounded-xl border-2 @error('email') border-red-500 @else border-gray-300 @enderror focus:border-primary focus:ring-4 focus:ring-primary/20 transition">
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" required
                                   class="w-full px-5 py-4 rounded-xl border-2 @error('phone') border-red-500 @else border-gray-300 @enderror focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                                   placeholder="+1234567890">
                            @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-bold text-gray-900 mb-6">Change Password (Optional)</h4>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">New Password</label>
                                <input type="password" name="password" placeholder="Leave blank to keep current"
                                       class="w-full px-5 py-4 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition">
                                @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation"
                                       class="w-full px-5 py-4 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition">
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit"
                                class="px-12 py-5 bg-primary hover:bg-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 text-lg flex items-center space-x-3">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</x-student-layout>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard • OnlineCourse</title>

    <!-- Tailwind CDN + Your Custom Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        secondary: '#F59E0B',
                        light: '#F8FAFC'
                    },
                    fontFamily: {
                        raleway: ['Raleway', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1.5s ease-in-out'
                    },
                    keyframes: {
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-20px)' } },
                        fadeIn: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-light" style="font-family: 'Raleway', sans-serif;">

    <!-- Floating Background Orbs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-10 left-10 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-secondary/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s;"></div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-bold text-primary">Student Dashboard</h1>
            </div>
            <div class="flex items-center space-x-6">
                <div class="text-right">
                    <p class="text-gray-700 font-semibold">{{ Auth::user()->full_name }}</p>
                    <p class="text-sm text-gray-500">Ref: {{ Auth::user()->reference_code }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-medium transition transform hover:scale-105">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-12">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-primary to-blue-900 text-white rounded-3xl p-10 shadow-2xl mb-10 animate-fade-in">
            <h2 class="text-4xl font-bold mb-3">Welcome back, {{ Auth::user()->full_name }}!</h2>
            <p class="text-xl opacity-90">You're enrolled and ready to learn. Let's begin your journey!</p>
            <div class="mt-6 flex items-center space-x-8 text-lg">
                <div>
                    <span class="font-bold text-secondary">{{ Auth::user()->course->title ?? 'N/A' }}</span><br>
                    <span class="text-sm opacity-80">Enrolled Course</span>
                </div>
                <div>
                    <span class="font-bold text-green-300">Approved</span><br>
                    <span class="text-sm opacity-80">Status</span>
                </div>
                <div>
                    <span class="font-bold">{{ Auth::user()->formatted_amount }}</span><br>
                    <span class="text-sm opacity-80">Amount Paid</span>
                </div>
            </div>
        </div>

        <!-- Course Card -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover:shadow-2xl transition transform hover:-translate-y-2 animate-fade-in" style="animation-delay: 0.3s;">
                <div class="w-20 h-20 bg-gradient-to-br from-primary to-blue-700 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-primary text-center mb-3">{{ Auth::user()->course->title ?? 'Your Course' }}</h3>
                <p class="text-gray-600 text-center mb-6">You are successfully enrolled and approved. Start learning now!</p>
                <a href="#" class="block text-center bg-gradient-to-r from-primary to-blue-800 text-white py-4 rounded-xl font-bold hover:shadow-lg transition">
                    Go to Course Materials
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="bg-gradient-to-br from-secondary to-orange-600 text-white rounded-2xl shadow-xl p-8 animate-fade-in" style="animation-delay: 0.5s;">
                <div class="text-5xl font-bold mb-2">1</div>
                <p class="text-xl opacity-90">Active Course</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-2xl shadow-xl p-8 animate-fade-in" style="animation-delay: 0.7s;">
                <div class="text-5xl font-bold mb-2">100%</div>
                <p class="text-xl opacity-90">Enrollment Approved</p>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-16 text-center bg-white rounded-3xl shadow-xl p-10 border border-gray-100 animate-fade-in" style="animation-delay: 0.9s;">
            <h3 class="text-3xl font-bold text-primary mb-4">Need Help?</h3>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                If you have any questions about your course, materials, or certificate, feel free to contact us anytime.
            </p>
            <div class="flex justify-center space-x-6">
                <a href="mailto:support@onlinecourse.com" class="bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-900 transition">
                    Email Support
                </a>
                <a href="https://wa.me/977XXXXXXXXXX" class="bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition">
                    WhatsApp Us
                </a>
            </div>
        </div>
    </div>

    <!-- Success Toast on Login -->
    @if(session('swal'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome back, {{ Auth::user()->full_name }}!',
                text: 'You are now logged into your student dashboard.',
                timer: 4000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif
</body>
</html>

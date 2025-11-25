<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login • OnlineCourse</title>

    <!-- Tailwind CDN + Your Custom Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',   // Deep blue
                        secondary: '#F59E0B', // Amber
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
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts: Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-light flex items-center justify-center px-4" style="font-family: 'Raleway', sans-serif;">

    <div class="w-full max-w-md">
        <!-- Floating Decorative Elements -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-10 -left-10 w-72 h-72 bg-primary/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-20 -right-10 w-96 h-96 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s;"></div>
        </div>

        <div class="text-center mb-10 animate-fade-in">
            <h1 class="text-5xl font-bold text-primary mb-3">Welcome Back!</h1>
            <p class="text-gray-600 text-lg">Log in to continue your learning journey</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100 animate-fade-in" style="animation-delay: 0.3s;">

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ $errors->first() }}',
                        confirmButtonColor: '#1E3A8A'
                    });
                </script>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Login Field -->
                <div>
                    <label class="block text-primary font-semibold mb-2">Email or Reference Code</label>
                    <input type="text" name="login" value="{{ old('login') }}" required autofocus
                           class="w-full px-5 py-4 rounded-xl border-2 border-gray-200 focus:border-primary focus:outline-none transition-all duration-300 text-gray-800 placeholder-gray-400"
                           placeholder="e.g. student@example.com or REF12345">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-primary font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-5 py-4 rounded-xl border-2 border-gray-200 focus:border-primary focus:outline-none transition-all duration-300 text-gray-800"
                           placeholder="Enter your password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-5 h-5 text-primary rounded focus:ring-primary">
                        <span class="ml-3 text-gray-700 font-medium">Remember me</span>
                    </label>
                    {{-- <a href="#" class="text-secondary hover:underline font-medium">Forgot?</a> --}}
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-5 mt-8 bg-gradient-to-r from-primary to-blue-900 text-white font-bold text-lg rounded-xl
                               shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Login to Dashboard
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="/" class="text-secondary font-bold hover:underline">Enroll Now →</a>
                </p>
                <p class="text-xs text-gray-500 mt-4">
                    Use your registered <span class="font-mono bg-gray-100 px-2 py-1 rounded">Reference Code</span> or email
                </p>
            </div>
        </div>

        <!-- Footer Credit -->
        <div class="text-center mt-8 text-gray-500 text-sm animate-fade-in" style="animation-delay: 0.6s;">
            © {{ date('Y') }} OnlineCourse • Made with ❤️ for learners
        </div>
    </div>
</body>
</html>

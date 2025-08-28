<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon) }}" alt="FinHedge Logo"
        class="h-auto w-auto">

    <script src="https://cdn.tailwindcss.com"></script>
     <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-frontend-header />

    <main>
        {{ $slot }}
    </main>


</body>
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
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' }
                    },
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' }
                    }
                }
            }
        }
    }
</script>

<style type="text/tailwindcss">
    @layer utilities {
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* ✅ Navbar hover effect */
        .nav-link {
            @apply text-gray-700 border-b-2 border-transparent transition duration-300;
        }
        .nav-link:hover {
            @apply text-secondary border-secondary font-semibold;
        }
        .nav-link-active {
            @apply text-primary font-semibold border-b-2 border-secondary;
        }
    }
</style>

</html>

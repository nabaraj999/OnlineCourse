<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon) }}" alt="FinHedge Logo"
        class="h-auto w-auto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-frontend-header />

    <main>
        {{ $slot }}
    </main>

    <x-frontend-footer />
</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 50%;
        background: linear-gradient(45deg, #667eea, #764ba2);
        transition: all 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
        left: 0;
    }

    .nav-link:hover {
        color: #667eea;
        transform: translateY(-2px);
    }

    .social-icon {
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        transform: scale(1.2) rotate(5deg);
    }

    .mobile-menu {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .mobile-menu.active {
        transform: translateX(0);
    }

    .hamburger span {
        display: block;
        height: 3px;
        width: 25px;
        background: #4a5568;
        margin: 5px 0;
        transition: all 0.3s ease;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .search-box {
        transition: all 0.3s ease;
    }

    .search-box:focus {
        width: 300px;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
    }

    @media (max-width: 768px) {
        .search-box:focus {
            width: 200px;
        }
    }

    .floating-animation {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }
</style>

</html>

<nav class="bg-white shadow-md fixed w-full top-0 z-50">

    <!-- TOP CONTACT BAR -->
    <div class="bg-primary text-white text-xs sm:text-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-2">
            <!-- LEFT CONTACTS -->
            <div class="flex items-center space-x-4">
                <a href="mailto:{{ $company->email }}" class="flex items-center space-x-1 p-1 hover:text-secondary transition">
                    <i class="fas fa-envelope"></i>
                    <span class="hidden sm:inline">{{ $company->email }}</span>
                </a>

                <a href="tel:{{ $company->phone_number }}" class="flex items-center space-x-1 p-1 hover:text-secondary transition">
                    <i class="fas fa-phone"></i>
                    <span class="hidden sm:inline">{{ $company->phone_number }}</span>
                </a>

                <a href="https://wa.me/{{ $company->whatsapp_number }}" class="flex items-center p-1 hover:text-secondary transition">
                    <i class="fab fa-whatsapp"></i>
                    <span class="hidden sm:inline">{{ $company->whatsapp_number }}</span>
                </a>
            </div>

            <!-- SOCIAL ICONS -->
            <div class="flex items-center space-x-3">
                <a href="#" class="p-1 hover:text-secondary transition"><i class="fab fa-facebook"></i></a>
                <a href="#" class="p-1 hover:text-secondary transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="p-1 hover:text-secondary transition"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                <img src="{{ Storage::url($company->logo) }}" alt="Logo" class="h-10 sm:h-12 w-auto">
            </a>

            <!-- DESKTOP MENU -->
            <div class="hidden lg:flex items-center space-x-10">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="#testimonials" class="nav-link">Testimonials</a>
                <a href="{{ route('mentors.index') }}" class="nav-link">Mentors</a>
                <a href="{{ route('blogs.index') }}" class="nav-link">Blog</a>
                <a href="{{ route('courses.index') }}" class="nav-link">Courses</a>
            </div>

            <!-- DESKTOP RIGHT -->
            <div class="hidden lg:flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search..."
                        class="border border-gray-300 rounded-lg pl-4 pr-10 py-2 w-48 focus:outline-none focus:ring-2 focus:ring-secondary text-sm">
                    <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                </div>
                <a href="{{ route('login') }}"
                    class="bg-secondary hover:bg-amber-600 px-5 py-2.5 rounded-lg text-white font-semibold shadow-md transition">
                    Student Portal
                </a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button id="mobile-menu-button" class="lg:hidden text-primary text-3xl p-2">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU (FULLY FIXED & CLEAN) -->
    <div id="mobile-menu"
         class="lg:hidden bg-white shadow-lg border-t border-gray-200 overflow-hidden transition-all duration-500 ease-in-out"
         style="max-height: 0;">
        <div class="px-6 py-6 space-y-5">
            <a href="{{ route('home') }}" class="block nav-link text-lg font-medium">Home</a>
            <a href="#testimonials" class="block nav-link text-lg font-medium">Testimonials</a>
            <a href="{{ route('mentors.index') }}" class="block nav-link text-lg font-medium">Mentors</a>
            <a href="{{ route('blogs.index') }}" class="block nav-link text-lg font-medium">Blog</a>
            <a href="{{ route('courses.index') }}" class="block nav-link text-lg font-medium">Courses</a>

            <!-- Mobile Search -->
            <div class="relative mt-4">
                <input type="text" placeholder="Search..."
                    class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-secondary text-base">
                <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
            </div>

            <!-- Mobile Login Button -->
            <a href="{{ route('login') }}"
                class="block bg-secondary hover:bg-amber-600 text-white text-center py-3.5 rounded-lg font-semibold text-lg shadow-md transition">
                Student Portal
            </a>
        </div>
    </div>
</nav>

<!-- CUSTOM CSS -->
<style>
    .nav-link {
        @apply text-gray-700 hover:text-primary transition duration-300 relative;
    }
    .nav-link.active {
        @apply text-primary font-bold;
    }
    .nav-link.active::after {
        content: '';
        @apply absolute bottom-0 left-0 w-full h-0.5 bg-primary;
    }

    #mobile-menu {
        max-height: 0;
        transition: max-height 0.5s ease-in-out;
        overflow: hidden;
    }
    #mobile-menu.open {
        max-height: 600px;
    }

    body {
        padding-top: 135px; /* Adjust if needed */
    }
    @media (min-width: 1024px) {
        body { padding-top: 110px; }
    }

    .bg-primary   { background-color: #1E3A8A; }
    .text-primary { color: #1E3A8A; }
    .bg-secondary { background-color: #F59E0B; }
    .text-secondary { color: #F59E0B; }
</style>

<!-- MOBILE MENU SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('mobile-menu-button');
        const menu   = document.getElementById('mobile-menu');

        button.addEventListener('click', () => {
            menu.classList.toggle('open');
            menu.style.maxHeight = menu.classList.contains('open') ? menu.scrollHeight + 'px' : '0';
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('open');
                menu.style.maxHeight = '0';
            });
        });

        // Active link highlighting
        const setActiveLink = () => {
            const path = window.location.pathname;
            const hash = window.location.hash;

            document.querySelectorAll('.nav-link').forEach(link => {
                const href = link.getAttribute('href');
                let active = false;

                if (href.startsWith('#')) active = href === hash;
                else if (href === '/' || href === '{{ route('home') }}') active = path === '/' || path === '';
                else active = path.startsWith(href);

                link.classList.toggle('active', active);
            });
        };

        setActiveLink();
        window.addEventListener('hashchange', setActiveLink);
    });
</script>

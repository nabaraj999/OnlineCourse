<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-transition { transition: all 0.3s ease; }
        .content-transition { transition: all 0.3s ease; }
        .active {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-left: 4px solid #F59E0B;
        }
        /* Overlay for mobile */
        #sidebarOverlay {
            @apply fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden;
        }
    </style>
</head>

<body class="font-raleway bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Overlay (for mobile) - THIS WAS MISSING IN YOUR CODE -->
        <div id="sidebarOverlay" class="hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar-transition bg-primary text-white w-64 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto">

            <!-- Logo -->
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </div>
                    <span class="text-xl font-semibold hidden lg:block">Student Panel</span>
                </div>
                <button id="sidebarToggle" class="lg:hidden text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <!-- Navigation -->
<nav class="flex-1 mt-6 px-4 overflow-y-auto">
    <ul class="space-y-2">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('student.dashboard') }}"
               class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('student.dashboard') ? 'active bg-white bg-opacity-10 border-l-4 border-secondary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="hidden lg:block">Dashboard</span>
            </a>
        </li>

        <!-- Enroll Course -->
        <li>
    <a href="{{ route('student.my-courses') }}"
       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('student.my-courses') ? 'active' : '' }}">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m-6 0h6"/>
        </svg>
        <span class="hidden lg:block">My Courses</span>
    </a>
</li>

        <!-- Payment Receipt -->
        <li>
            <a href="{{ route('student.payment-receipts') }}"
               class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="hidden lg:block">Payment Receipt</span>
            </a>
        </li>

        <!-- My Certificate -->
        <li>
            <a href="#"
               class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="hidden lg:block">My Certificate</span>
            </a>
        </li>

        <!-- Suggestions -->
        <li>
            <a href="{{ route('student.suggestions.index') }}"
               class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span class="hidden lg:block">Suggestions</span>
            </a>
        </li>

    </ul>
</nav>

            <!-- Logout -->
            <div class="p-4 border-t border-white border-opacity-20">
                <a href="{{ route('logout') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-red-600 hover:bg-red-700 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="hidden lg:block">Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10 border-b">
                <div class="flex items-center justify-between p-4">
                    <button id="mobileMenuToggle" class="lg:hidden text-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="relative flex-1 max-w-xl mx-4">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Search courses, documents...">
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:text-primary rounded-full hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>

                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($student->name ?? 'Student', 0, 2)) }}
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-gray-900">{{ $student->name ?? 'Student' }}</p>
                                <p class="text-xs text-gray-500">Computer Science</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Slot -->
            <main class="flex-1 overflow-y-auto bg-light p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Fixed JavaScript (Now Actually Works) -->
    <script>
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        mobileMenuToggle?.addEventListener('click', toggleSidebar);
        sidebarToggle?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Auto highlight current page
        document.querySelectorAll('#sidebar a').forEach(link => {
            if (link.href === location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>

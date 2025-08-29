<!-- ✅ Top Info Bar -->
<nav class="bg-white shadow-md fixed w-full z-50 top-0 left-0">
  <!-- Top Contact Bar -->
  <div class="bg-primary text-white text-xs sm:text-sm">
    <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center px-4 py-2">
      <!-- Left: Contact Info -->
      <div class="flex flex-wrap space-x-4 sm:space-x-6 items-center">
        <a href="mailto:Test@gmail.com" class="hover:text-secondary flex items-center transition">
          <i class="fas fa-envelope mr-1 sm:mr-2"></i>
          <span class="hidden sm:inline">Test@gmail.com</span>
        </a>
        <a href="tel:+9779842943275" class="hover:text-secondary flex items-center transition">
          <i class="fas fa-phone mr-1 sm:mr-2"></i>
          <span class="hidden sm:inline">+977 9842943275</span>
        </a>
        <a href="https://wa.me/9861404971" target="_blank" class="hover:text-secondary flex items-center transition">
          <i class="fab fa-whatsapp mr-1 sm:mr-2"></i>
          <span class="hidden sm:inline">9861404971</span>
        </a>
        <a href="viber://chat?number=%2B9779861404972" class="hover:text-secondary flex items-center transition">
          <i class="fab fa-viber mr-1 sm:mr-2"></i>
          <span class="hidden sm:inline">9861404972</span>
        </a>
      </div>

      <!-- Right: Social Media -->
      <div class="flex space-x-3 sm:space-x-4">
        <a href="#" class="hover:text-secondary transition"><i class="fab fa-facebook"></i></a>
        <a href="#" class="hover:text-secondary transition"><i class="fab fa-instagram"></i></a>
        <a href="#" class="hover:text-secondary transition"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </div>

  <!-- ✅ Main Navbar -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16 sm:h-20">
      <!-- Left: Logo + Menu -->
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <a href="#">
            <img class="h-8 sm:h-10 w-auto" src="{{ Storage::url($company->logo) }}" alt="EduLearn Logo">
          </a>
        </div>
        <!-- Desktop Menu -->
        <div class="hidden lg:ml-10 lg:flex lg:space-x-8">
          <a href="{{ route('home') }}" class="nav-link">Home</a>
          <a href="#testimonials" class="nav-link">Testimonials</a>
          <a href="#mentors" class="nav-link">Mentors</a>
          <a href="#blog" class="nav-link">Blog</a>
          <a href="#courses" class="nav-link">Courses</a>
        </div>
      </div>

      <!-- Right: Search + Student Portal -->
      <div class="hidden lg:flex items-center space-x-4">
        <div class="relative">
          <input type="text" placeholder="Search..." class="border border-gray-300 rounded-lg pl-3 pr-10 py-1.5 focus:ring-2 focus:ring-secondary focus:outline-none text-sm">
          <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-secondary">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <a href="#" class="bg-secondary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg font-medium transition duration-300 shadow-md text-sm">
          Student Portal
        </a>
      </div>

      <!-- Mobile Button -->
      <div class="lg:hidden flex items-center">
        <button id="mobile-menu-button" class="text-primary hover:text-secondary focus:outline-none">
          <i class="fas fa-bars text-xl sm:text-2xl"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- ✅ Mobile Menu -->
  <div id="mobile-menu" class="lg:hidden bg-white shadow-md px-4 py-4 space-y-3 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0;">
    <a href="{{ route('home') }}" class="nav-link block">Home</a>
    <a href="#testimonials" class="nav-link block">Testimonials</a>
    <a href="#mentors" class="nav-link block">Mentors</a>
    <a href="#blog" class="nav-link block">Blog</a>
    <a href="#courses" class="nav-link block">Courses</a>
    <div class="relative">
      <input type="text" placeholder="Search..." class="w-full border border-gray-300 rounded-lg pl-3 pr-10 py-1.5 focus:ring-2 focus:ring-secondary focus:outline-none text-sm">
      <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-secondary">
        <i class="fas fa-search"></i>
      </button>
    </div>
    <a href="#" class="block bg-secondary text-white px-3 py-2 rounded-lg text-center font-medium">Student Portal</a>
  </div>
</nav>

<!-- ✅ Styles -->
<style>
  .nav-link {
    @apply text-gray-600 hover:text-primary font-medium transition duration-300 py-2;
  }
  .nav-link.active {
    @apply border-b-2 border-yellow-500 text-primary font-semibold;
  }
  #mobile-menu.open {
    max-height: 500px; /* Increased to accommodate more content */
  }
  body {
    padding-top: 100px; /* Adjust based on navbar + top bar height */
  }
  .bg-primary {
    background-color: #1E3A8A; /* Blue for top bar */
  }
  .bg-secondary {
    background-color: #F59E0B; /* Orange for buttons */
  }
  .text-primary {
    color: #1E3A8A; /* Blue for text */
  }
  .hover\:text-secondary:hover {
    color: #F59E0B; /* Orange on hover */
  }
  .hover\:bg-opacity-90:hover {
    background-color: #D97706; /* Darker orange on hover */
  }
</style>

<!-- ✅ Scripts -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    // ✅ Check if elements exist
    if (!mobileMenuButton || !mobileMenu) {
      console.error('Mobile menu button or menu not found');
      return;
    }

    // ✅ Toggle Menu (open/close)
    mobileMenuButton.addEventListener('click', () => {
      console.log('Mobile menu button clicked'); // Debug log
      if (mobileMenu.classList.contains('open')) {
        mobileMenu.classList.remove('open');
        mobileMenu.style.maxHeight = '0';
      } else {
        mobileMenu.classList.add('open');
        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
      }
    });

    // ✅ Auto close menu on link click
    document.querySelectorAll('#mobile-menu a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        mobileMenu.style.maxHeight = '0';
      });
    });

    // ✅ Set active link based on current page
    function setActiveLink() {
      const links = document.querySelectorAll('.nav-link');
      const currentPath = window.location.pathname;
      const currentHash = window.location.hash || '#home';

      links.forEach(link => {
        const href = link.getAttribute('href');
        const isActive = (href === currentPath || href === currentHash || (href === '{{ route("home") }}' && currentPath === '/'));
        link.classList.toggle('active', isActive);
      });
    }
    setActiveLink();
    window.addEventListener('hashchange', setActiveLink);
  });
</script>

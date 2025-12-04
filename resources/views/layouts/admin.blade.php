<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin @yield('title', 'Dashboard')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">

    <!-- Desktop Sidebar -->
    <aside class="bg-[#7dd3d8] w-64 min-h-screen p-4 hidden lg:flex flex-col fixed top-0 left-0 z-30 transition-transform duration-300 shadow-lg">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white flex items-center space-x-2">
                <i class="fas fa-car-side"></i>
                <span>CuciCar</span>
            </h1>
        </div>
        
        <nav class="space-y-2 flex-1">
            <a href="{{ auth()->user()->role === 'owner' ? route('dashboard.owner', ['periode' => 'bulan_ini']) : route('dashboard.admin') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                {{ request()->is('dashboard/admin') || request()->is('dashboard/owner') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.bookings.index') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                {{ request()->is('admin/bookings*') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-calendar-check w-5"></i>
                <span>Booking</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                {{ request()->is('admin/users*') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Data User</span>
            </a>

            <a href="{{ route('pakets.index.public') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                {{ request()->is('pakets*') || request()->is('harga*') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-tag w-5"></i>
                <span>Harga</span>
            </a>

            @if(Auth::user()->role === 'owner')
                <a href="{{ route('owner.pegawais.index') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                    {{ request()->is('owner/pegawais*') || request()->is('*/pegawais*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-users-cog w-5"></i>
                    <span>Atur Pegawai</span>
                </a>
            @endif
            
            <a href="{{ route('admin.blogs.index') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                {{ request()->is('admin/blogs*') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-newspaper w-5"></i>
                <span>Artikel</span>
            </a>

           <a href="{{ route('admin.aboutus.index') }}" 
    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
    {{ request()->is('admin/aboutus*') ? 'bg-white bg-opacity-25' : '' }}">
    <i class="fas fa-info-circle w-5"></i>
    <span>About Us</span>
</a>

            <a href="{{ route('admin.profile.show') }}" 
                class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                {{ request()->is('admin/profile*') ? 'bg-white bg-opacity-25' : '' }}">
                <i class="fas fa-user-circle w-5"></i>
                <span>Profile</span>
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="border-t border-white border-opacity-20 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-lg flex items-center justify-center space-x-2 transition duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="lg:hidden bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-[60] px-4 py-3">
        <div class="flex items-center justify-between">
            <button id="mobile-menu-btn" class="bg-teal-custom text-gray-700 p-2 rounded-lg hover:bg-teal-dark transition duration-200 focus:outline-none focus:ring-2 focus:ring-teal-dark active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center space-x-1">
                <i class="fas fa-car-side text-teal-custom"></i>
                <span>Cuci<span class="text-teal-custom">Car</span></span>
            </h1>
            <div class="w-10 h-10 flex items-center justify-center">
                <a href="{{ route('admin.profile.show') }}" class="text-gray-600 hover:text-teal-custom transition">
                    <i class="fas fa-user-circle text-2xl"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-[70] hidden transition-opacity duration-300"></div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="lg:hidden fixed top-0 left-0 h-full bg-[#7dd3d8] w-64 sm:w-72 z-[80] transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
        <div class="p-4 flex-1 overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-xl sm:text-2xl font-bold text-white flex items-center space-x-2">
                    <i class="fas fa-car-side"></i>
                    <span>CuciCar</span>
                </h1>
                <button id="close-sidebar" class="text-white text-2xl hover:bg-white hover:bg-opacity-20 w-8 h-8 rounded-full flex items-center justify-center transition duration-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ auth()->user()->role === 'owner' ? route('dashboard.owner') : route('dashboard.admin') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                    {{ request()->is('dashboard/admin') || request()->is('dashboard/owner') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                    {{ request()->is('admin/bookings*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span>Booking</span>
                </a>
                <a href="{{ route('admin.users.index') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                    {{ request()->is('admin/users*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Data User</span>
                </a>
                <a href="{{ route('pakets.index.public') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200">
                    <i class="fas fa-tag w-5"></i>
                    <span>Harga</span>
                </a>
                @if(Auth::user()->role === 'owner')
                    <a href="{{ route('owner.pegawais.index') }}" 
                        class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200">
                        <i class="fas fa-users-cog w-5"></i>
                        <span>Atur Pegawai</span>
                    </a>
                @endif
                <a href="{{ route('admin.blogs.index') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                    {{ request()->is('admin/blogs*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-newspaper w-5"></i>
                    <span>Artikel</span>

                <a href="{{ route('admin.aboutus.index') }}" 
                        class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200 
                        {{ request()->is('admin/aboutus*') ? 'bg-white bg-opacity-25' : '' }}">
                        <i class="fas fa-info-circle w-5"></i>
                        <span>About Us</span>
                </a>
                </a>
                <a href="{{ route('admin.profile.show') }}" 
                    class="flex items-center space-x-3 text-gray-700 hover:bg-white hover:bg-opacity-20 p-3 rounded-lg transition duration-200
                    {{ request()->is('admin/profile*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-user-circle w-5"></i>
                    <span>Profile</span>
                </a>
            </nav>
        </div>

        <!-- Logout Button in Mobile Sidebar -->
        <div class="p-4 border-t border-white border-opacity-20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-lg flex items-center justify-center space-x-2 transition duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main content -->
    <main class="min-h-screen lg:ml-64 pt-16 lg:pt-0">
        <div class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Sidebar Script -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        function openMobileSidebar() {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileSidebar() {
            mobileSidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        mobileMenuBtn?.addEventListener('click', openMobileSidebar);
        closeSidebar?.addEventListener('click', closeMobileSidebar);
        mobileOverlay?.addEventListener('click', closeMobileSidebar);
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeMobileSidebar();
            }
        });

        const sidebarLinks = mobileSidebar?.querySelectorAll('a');
        sidebarLinks?.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeMobileSidebar();
                }
            });
        });
    </script>

    @yield('modals')

</body>
</html>=
<!-- resources/views/admin/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-item:hover {
            transform: translateX(4px);
            transition: all 0.2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased">

    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 w-72 h-full bg-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col">
        <!-- Logo Section -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-utensils text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                            EHF RESTO
                        </h1>
                        <p class="text-xs text-gray-500 font-medium">Admin Panel</p>
                    </div>
                </div>
                <button id="close-sidebar" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <span class="ml-4 font-medium">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

            <a href="{{ route('admin.menus.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.menus.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.menus.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-utensils"></i>
                </div>
                <span class="ml-4 font-medium">Menu Items</span>
                @if(request()->routeIs('admin.menus.*'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.categories.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-tags"></i>
                </div>
                <span class="ml-4 font-medium">Categories</span>
                @if(request()->routeIs('admin.categories.*'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

            <a href="{{ route('admin.tables.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.tables.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.tables.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-chair"></i>
                </div>
                <span class="ml-4 font-medium">Tables</span>
                @if(request()->routeIs('admin.tables.*'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

            <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.orders.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="ml-4 font-medium">Orders</span>
                <div class="ml-auto flex items-center space-x-2">
                    @if(request()->routeIs('admin.orders.*'))
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    @endif
                    
                </div>
            </a>

            <a href="{{ route('admin.payment-methods.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.payment-methods.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.payment-methods.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-credit-card"></i>
                </div>
                <span class="ml-4 font-medium">Payment Methods</span>
                @if(request()->routeIs('admin.payment-methods.*'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

            <a href="{{ route('admin.reports.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.reports.*') ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-all duration-200">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <span class="ml-4 font-medium">Reports</span>
                @if(request()->routeIs('admin.reports.*'))
                <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>

           
        </nav>

        <!-- User Profile Section -->
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Admin User</p>
                    <p class="text-xs text-gray-500">admin@ehfresto.com</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-72 flex flex-col min-h-screen">
        <!-- Top Header -->
        <header class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-200/50 sticky top-0 z-30">
           
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 animate-fade-in">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-500">
                <div class="flex items-center space-x-4">
                    <span>&copy; 2025 EHF Restaurant. All rights reserved.</span>
                </div>
                <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                    <span>Version 1.0.0</span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span>Made with ❤️ by EHF Creative</span>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        function showSidebar() {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        mobileMenuBtn?.addEventListener('click', showSidebar);
        closeSidebar?.addEventListener('click', hideSidebar);
        mobileOverlay?.addEventListener('click', hideSidebar);

        // Auto-hide sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                hideSidebar();
            }
        });

        // Form loading states
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = form.querySelector('button[type="submit"]');
                if (button && !button.disabled) {
                    button.disabled = true;
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                    
                    // Reset after 5 seconds as fallback
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }, 5000);
                }
            });
        });
    </script>
</body>
</html>
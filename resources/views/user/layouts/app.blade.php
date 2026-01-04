<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EHF RESTO')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900 hover:text-primary-600 transition-colors duration-200">
                        🍽️ EHF RESTO
                    </a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-primary-600 font-medium transition-colors duration-200 border-b-2 border-transparent hover:border-primary-500">
                        Beranda
                    </a>
                    <a href="{{ route('scan.instructions') }}" 
                       class="text-gray-700 hover:text-primary-600 font-medium transition-colors duration-200 border-b-2 border-transparent hover:border-primary-500">
                        Cara Scan QR
                    </a>
                </nav>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-primary-600 focus:outline-none focus:text-primary-600" 
                            onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-6">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">
                        Beranda
                    </a>
                    <a href="{{ route('scan.instructions') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">
                        Cara Scan QR
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <p class="text-gray-600 text-sm">
                    &copy; {{ date('Y') }} EHF RESTO. Hak cipta dilindungi.
                </p>
                <p class="text-gray-500 text-xs mt-1">
                    Dibuat dengan ❤️ untuk pengalaman bersantap terbaik
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Auto-hide mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = event.target.closest('button');
            
            if (!menu.contains(event.target) && !button) {
                menu.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
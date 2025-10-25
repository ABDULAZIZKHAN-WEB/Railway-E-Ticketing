<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Railway E-Ticketing - Bangladesh Railway')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="navbar-railway">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-white text-xl font-bold flex items-center">
                        🚄 Bangladesh Railway E-Ticketing
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-white">Hello, {{ Auth::user()->name }}</span>
                            <a href="/dashboard" class="nav-link">Dashboard</a>
                            <a href="/my-bookings" class="nav-link">My Bookings</a>
                            <a href="/live-tracking" class="nav-link">Live Tracking</a>
                            <form method="POST" action="/logout" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-green-200 transition duration-200">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="/live-tracking" class="nav-link">Live Tracking</a>
                            <a href="/login" class="nav-link">Login</a>
                            <a href="/register" class="btn-railway-outline bg-white text-green-600 hover:bg-green-600 hover:text-white">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-railway mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">🚄 Bangladesh Railway</h3>
                    <p class="text-gray-300 text-sm">Official e-ticketing platform for Bangladesh Railway. Book your train tickets online with ease and convenience.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="/" class="hover:text-white">Home</a></li>
                        <li><a href="/search-trains" class="hover:text-white">Search Trains</a></li>
                        <li><a href="/live-tracking" class="hover:text-white">Live Tracking</a></li>
                        <li><a href="/contact" class="hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="/help" class="hover:text-white">Help Center</a></li>
                        <li><a href="/faq" class="hover:text-white">FAQ</a></li>
                        <li><a href="/terms" class="hover:text-white">Terms & Conditions</a></li>
                        <li><a href="/privacy" class="hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p>📞 Hotline: 16318</p>
                        <p>📧 Email: info@railway.gov.bd</p>
                        <p>🕒 24/7 Customer Support</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Bangladesh Railway. All rights reserved. | Developed with ❤️ for better railway services.</p>
            </div>
        </div>
    </footer>
</body>
</html>
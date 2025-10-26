@extends('layouts.railway')

@section('title', 'Railway E-Ticketing - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50">
    <!-- Hero Section with Search -->
    <div class="hero-railway">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold mb-4">🚄 Bangladesh Railway E-Ticketing</h1>
                <p class="text-xl opacity-90 max-w-2xl mx-auto">
                    Book your train tickets online with ease. Fast, secure, and convenient railway booking system.
                </p>
            </div>

            <!-- Train Search Form -->
            <div class="max-w-4xl mx-auto search-form-railway">
                <div class="space-y-6">
                    <form action="{{ route('search.trains') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- From Station -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Station</label>
                                <select name="from_station" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900">
                                    <option value="">Select Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->station_code }}">{{ $station->station_name }} ({{ $station->station_name_bn }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- To Station -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Station</label>
                                <select name="to_station" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900">
                                    <option value="">Select Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->station_code }}">{{ $station->station_name }} ({{ $station->station_name_bn }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Journey Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date</label>
                                <input type="date" name="journey_date" required min="{{ date('Y-m-d') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900">
                            </div>

                            <!-- Search Button -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full btn-railway text-center">
                                    🔍 Search Trains
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @guest
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Get Started Today</h2>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-green-700 transition duration-200 shadow-lg">
                    📝 Create Account
                </a>
                <a href="{{ route('login') }}" class="border-2 border-green-600 text-green-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-green-50 transition duration-200">
                    🔐 Login
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Welcome back, {{ Auth::user()->name }}!</h2>
            <div class="space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-green-700 transition duration-200 shadow-lg">
                    📊 Go to Dashboard
                </a>
                <a href="{{ route('my.bookings') }}" class="border-2 border-green-600 text-green-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-green-50 transition duration-200">
                    🎫 My Bookings
                </a>
            </div>
        </div>
    </div>
    @endguest

    <!-- Popular Routes -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">🔥 Popular Routes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($popularRoutes as $route)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">{{ $route['from'] }} → {{ $route['to'] }}</span>
                        <span class="text-green-600 font-bold">৳ {{ $route['price'] }}</span>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $route['trains'] }} • {{ $route['duration'] }} journey</p>
                    <a href="{{ route('search.trains') }}?from={{ urlencode($route['from']) }}&to={{ urlencode($route['to']) }}" class="w-full bg-green-100 text-green-700 py-2 rounded-lg hover:bg-green-200 transition duration-200 text-center block">
                        View Trains
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Why Choose Our E-Ticketing?</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Instant Booking</h3>
                    <p class="text-gray-600">Book tickets in seconds with real-time seat availability</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="text-5xl mb-4">🔒</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Secure Payment</h3>
                    <p class="text-gray-600">SSL encrypted payments with multiple gateway options</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="text-5xl mb-4">📱</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Mobile Friendly</h3>
                    <p class="text-gray-600">Book and manage tickets on any device, anywhere</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="text-5xl mb-4">🎫</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Digital Tickets</h3>
                    <p class="text-gray-600">Paperless e-tickets with QR codes for easy verification</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gradient-to-r from-green-600 to-red-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $stats['happy_passengers'] }}+</div>
                    <div class="text-green-100">Happy Passengers</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $stats['train_routes'] }}</div>
                    <div class="text-green-100">Train Routes</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $stats['customer_support'] }}</div>
                    <div class="text-green-100">Customer Support</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $stats['uptime_guarantee'] }}</div>
                    <div class="text-green-100">Uptime Guarantee</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
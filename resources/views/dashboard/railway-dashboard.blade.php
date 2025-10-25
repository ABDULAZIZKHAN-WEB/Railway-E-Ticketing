@extends('layouts.railway')

@section('title', 'Passenger Dashboard - Bangladesh Railway E-Ticketing')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-green-600 to-red-600 text-white rounded-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">🚄 Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-green-100">Manage your railway bookings and account from here</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-sm text-green-100">Member since</div>
                        <div class="font-semibold">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <a href="/search-trains" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="text-3xl mr-4 group-hover:scale-110 transition duration-200">🎫</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Book Ticket</h3>
                        <p class="text-sm text-gray-600">Search & book trains</p>
                    </div>
                </div>
            </a>

            <a href="/my-bookings" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="text-3xl mr-4 group-hover:scale-110 transition duration-200">📋</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">My Bookings</h3>
                        <p class="text-sm text-gray-600">View booking history</p>
                    </div>
                </div>
            </a>

            <a href="/live-tracking" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="text-3xl mr-4 group-hover:scale-110 transition duration-200">📍</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Live Tracking</h3>
                        <p class="text-sm text-gray-600">Track train location</p>
                    </div>
                </div>
            </a>

            <a href="/profile" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="text-3xl mr-4 group-hover:scale-110 transition duration-200">👤</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Profile</h3>
                        <p class="text-sm text-gray-600">Update account info</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Bookings -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">📋 Recent Bookings</h2>
                        <a href="/my-bookings" class="text-green-600 hover:text-green-800 text-sm font-medium">View All</a>
                    </div>
                    
                    <!-- Mock booking data -->
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">Suborno Express (701)</h4>
                                    <p class="text-sm text-gray-600">Dhaka → Chittagong</p>
                                    <p class="text-xs text-gray-500">Journey: Nov 15, 2024 • AC Seat</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                    <p class="text-sm font-medium text-gray-800 mt-1">৳950</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">🎫</div>
                            <p>No recent bookings found</p>
                            <p class="text-sm mt-1">Start by booking your first train ticket!</p>
                            <a href="/search-trains" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition duration-200">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Info & Quick Stats -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">👤 Account Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-600">Full Name</label>
                            <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Email</label>
                            <p class="font-medium text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                        @if(Auth::user()->phone)
                        <div>
                            <label class="text-sm text-gray-600">Phone</label>
                            <p class="font-medium text-gray-800">{{ Auth::user()->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm text-gray-600">Account Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst(Auth::user()->status) }}
                            </span>
                        </div>
                    </div>
                    <a href="/profile" class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg mt-4 hover:bg-gray-200 transition duration-200">
                        Edit Profile
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Bookings</span>
                            <span class="font-semibold text-gray-800">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Spent</span>
                            <span class="font-semibold text-gray-800">৳0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Favorite Route</span>
                            <span class="font-semibold text-gray-800">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Loyalty Points</span>
                            <span class="font-semibold text-green-600">0 pts</span>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-800 mb-2">📢 Notifications</h4>
                    <div class="text-sm text-blue-700">
                        <p class="mb-2">• Welcome to Bangladesh Railway E-Ticketing!</p>
                        <p>• Complete your profile to get personalized recommendations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Routes -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🔥 Popular Routes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium text-gray-800">Dhaka → Chittagong</h4>
                            <span class="text-green-600 font-semibold">৳450+</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">5-7 hours • Multiple trains daily</p>
                        <button class="w-full bg-green-100 text-green-700 py-2 rounded-lg text-sm hover:bg-green-200 transition duration-200">
                            Search Trains
                        </button>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium text-gray-800">Dhaka → Sylhet</h4>
                            <span class="text-green-600 font-semibold">৳380+</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">6-8 hours • Express trains</p>
                        <button class="w-full bg-green-100 text-green-700 py-2 rounded-lg text-sm hover:bg-green-200 transition duration-200">
                            Search Trains
                        </button>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium text-gray-800">Dhaka → Rajshahi</h4>
                            <span class="text-green-600 font-semibold">৳320+</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">4-6 hours • Mail & express</p>
                        <button class="w-full bg-green-100 text-green-700 py-2 rounded-lg text-sm hover:bg-green-200 transition duration-200">
                            Search Trains
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
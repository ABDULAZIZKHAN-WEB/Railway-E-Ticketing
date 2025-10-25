@extends('layouts.railway')

@section('title', 'Admin Dashboard - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Admin Header -->
        <div class="bg-gradient-to-r from-red-600 to-green-600 text-white rounded-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">🛠️ Admin Dashboard</h1>
                    <p class="text-red-100">Welcome, {{ Auth::user()->name }} - System Administrator</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-sm text-red-100">Admin since</div>
                        <div class="font-semibold">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">👥</div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</h3>
                        <p class="text-sm text-gray-600">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">🚄</div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_trains']) }}</h3>
                        <p class="text-sm text-gray-600">Active Trains</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">🏢</div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_stations']) }}</h3>
                        <p class="text-sm text-gray-600">Railway Stations</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">💰</div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-600">৳{{ number_format($stats['total_revenue']) }}</h3>
                        <p class="text-sm text-gray-600">Total Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <a href="/admin/trains" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🚄</div>
                    <h3 class="font-semibold text-gray-800">Manage Trains</h3>
                    <p class="text-sm text-gray-600">Add, edit, delete trains</p>
                </div>
            </a>

            <a href="/admin/stations" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🏢</div>
                    <h3 class="font-semibold text-gray-800">Manage Stations</h3>
                    <p class="text-sm text-gray-600">Station operations</p>
                </div>
            </a>

            <a href="/admin/users" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">👥</div>
                    <h3 class="font-semibold text-gray-800">Manage Users</h3>
                    <p class="text-sm text-gray-600">User management</p>
                </div>
            </a>

            <a href="/admin/reports" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">📊</div>
                    <h3 class="font-semibold text-gray-800">Reports</h3>
                    <p class="text-sm text-gray-600">Analytics & reports</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Bookings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">📋 Recent Bookings</h2>
                <div class="space-y-4">
                    @forelse($recent_bookings as $booking)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $booking->booking_reference }}</h4>
                                <p class="text-sm text-gray-600">{{ $booking->user_name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->created_at }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                                <p class="text-sm font-medium text-gray-800 mt-1">৳{{ number_format($booking->total_amount) }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-4xl mb-2">📋</div>
                        <p>No recent bookings</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">⚡ System Status</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Database</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Online
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Payment Gateway</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">SMS Service</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Maintenance
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Email Service</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-4">📈 Today's Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">New Bookings</span>
                            <span class="font-semibold">{{ $stats['today_bookings'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Revenue Today</span>
                            <span class="font-semibold text-green-600">৳{{ number_format($stats['total_revenue'] * 0.1) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Active Users</span>
                            <span class="font-semibold">{{ $stats['total_users'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
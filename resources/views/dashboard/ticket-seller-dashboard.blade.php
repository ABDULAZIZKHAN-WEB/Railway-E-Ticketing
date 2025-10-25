@extends('layouts.railway')

@section('title', 'Ticket Seller Dashboard - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Ticket Seller Header -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">🎫 Ticket Seller Dashboard</h1>
                    <p class="text-purple-100">{{ $seller_stats['assigned_counter'] }} - {{ Auth::user()->name }}</p>
                    <p class="text-sm text-purple-200">{{ $seller_stats['shift'] }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-sm text-purple-100">Shift Status</div>
                        <div class="font-semibold">Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">🎫</div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $seller_stats['tickets_sold_today'] }}</h3>
                        <p class="text-sm text-gray-600">Tickets Sold Today</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">💰</div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-600">৳{{ number_format($seller_stats['cash_collected']) }}</h3>
                        <p class="text-sm text-gray-600">Cash Collected</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">⏳</div>
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-600">{{ $seller_stats['pending_transactions'] }}</h3>
                        <p class="text-sm text-gray-600">Pending Transactions</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">📊</div>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-600">{{ number_format($seller_stats['cash_collected'] / $seller_stats['tickets_sold_today']) }}</h3>
                        <p class="text-sm text-gray-600">Avg. Ticket Price</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Seller Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <a href="/ticket-seller/booking" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🎫</div>
                    <h3 class="font-semibold text-gray-800">New Booking</h3>
                    <p class="text-sm text-gray-600">Counter ticket booking</p>
                </div>
            </a>

            <a href="/ticket-seller/search" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🔍</div>
                    <h3 class="font-semibold text-gray-800">Search Booking</h3>
                    <p class="text-sm text-gray-600">Find by PNR/Phone</p>
                </div>
            </a>

            <a href="/ticket-seller/print" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🖨️</div>
                    <h3 class="font-semibold text-gray-800">Print Ticket</h3>
                    <p class="text-sm text-gray-600">Reprint tickets</p>
                </div>
            </a>

            <a href="/ticket-seller/cash-report" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">💰</div>
                    <h3 class="font-semibold text-gray-800">Cash Report</h3>
                    <p class="text-sm text-gray-600">Daily cash summary</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Sales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">💳 Recent Sales</h2>
                <div class="space-y-4">
                    @foreach($recent_sales as $sale)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $sale['pnr'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $sale['passenger'] }}</p>
                                <p class="text-xs text-gray-500">{{ $sale['train'] }} • {{ $sale['time'] }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-green-600">৳{{ number_format($sale['amount']) }}</span>
                                <p class="text-xs text-gray-500">Cash Payment</p>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Print Ticket</button>
                            <button class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">View Details</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Counter Operations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🏪 Counter Operations</h2>
                
                <!-- Quick Booking Form -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Quick Booking</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option>Dhaka</option>
                                    <option>Chittagong</option>
                                    <option>Sylhet</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option>Chittagong</option>
                                    <option>Dhaka</option>
                                    <option>Sylhet</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Journey Date</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" value="{{ date('Y-m-d') }}">
                        </div>
                        <button type="button" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg text-sm hover:bg-purple-700 transition duration-200">
                            Search Trains
                        </button>
                    </form>
                </div>

                <!-- PNR Search -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">PNR Search</h3>
                    <div class="flex space-x-2">
                        <input type="text" placeholder="Enter PNR or Phone" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition duration-200">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Shift Summary -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Shift Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shift Start</span>
                            <span class="font-medium">8:00 AM</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Hours Worked</span>
                            <span class="font-medium">6h 30m</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tickets Sold</span>
                            <span class="font-medium">{{ $seller_stats['tickets_sold_today'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Cash Collected</span>
                            <span class="font-medium text-green-600">৳{{ number_format($seller_stats['cash_collected']) }}</span>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-green-600 text-white py-2 px-4 rounded-lg text-sm hover:bg-green-700 transition duration-200">
                        End Shift & Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
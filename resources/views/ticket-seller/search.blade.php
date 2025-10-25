@extends('layouts.railway')

@section('title', 'Search Bookings - Ticket Seller')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🔍 Search Bookings</h1>
                    <p class="text-gray-600 mt-2">Find existing bookings by PNR, phone, or passenger details</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <a href="/ticket-seller/booking" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                        + New Booking
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Search Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Search Criteria</h2>
                    
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search By</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option>PNR Number</option>
                                <option>Phone Number</option>
                                <option>Passenger Name</option>
                                <option>Email Address</option>
                                <option>ID Number</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Value</label>
                            <input type="text" placeholder="Enter PNR, phone, name, etc." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date (Optional)</label>
                            <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Booking Status</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option>All Status</option>
                                <option>Confirmed</option>
                                <option>Pending</option>
                                <option>Cancelled</option>
                                <option>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 transition duration-200">
                            🔍 Search Bookings
                        </button>
                    </form>

                    <!-- Quick Search Buttons -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Quick Actions</h3>
                        <div class="space-y-2">
                            <button class="w-full text-left bg-blue-50 text-blue-700 p-3 rounded-lg hover:bg-blue-100 transition duration-200">
                                📋 Today's Bookings
                            </button>
                            <button class="w-full text-left bg-green-50 text-green-700 p-3 rounded-lg hover:bg-green-100 transition duration-200">
                                ✅ Recent Confirmations
                            </button>
                            <button class="w-full text-left bg-yellow-50 text-yellow-700 p-3 rounded-lg hover:bg-yellow-100 transition duration-200">
                                ⏳ Pending Payments
                            </button>
                            <button class="w-full text-left bg-red-50 text-red-700 p-3 rounded-lg hover:bg-red-100 transition duration-200">
                                ❌ Cancelled Bookings
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">Search Results</h2>
                            <span class="text-sm text-gray-600">3 bookings found</span>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <!-- Booking Result 1 -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800">PNR: BD123456789</h3>
                                    <p class="text-sm text-gray-600">Passenger: John Doe • Phone: 01712345678</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Confirmed
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Route</p>
                                    <p class="font-medium">Dhaka → Chittagong</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Train</p>
                                    <p class="font-medium">Suborno Express (#701)</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Journey Date</p>
                                    <p class="font-medium">{{ date('M d, Y') }}</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Total Amount</p>
                                    <p class="text-lg font-bold text-green-600">৳950</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition duration-200">
                                        View Details
                                    </button>
                                    <button class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200 transition duration-200">
                                        Print Ticket
                                    </button>
                                    <button class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm hover:bg-yellow-200 transition duration-200">
                                        Modify
                                    </button>
                                    <button class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm hover:bg-red-200 transition duration-200">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Result 2 -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800">PNR: BD123456790</h3>
                                    <p class="text-sm text-gray-600">Passenger: Jane Smith • Phone: 01798765432</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending Payment
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Route</p>
                                    <p class="font-medium">Dhaka → Sylhet</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Train</p>
                                    <p class="font-medium">Silk City Express (#711)</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Journey Date</p>
                                    <p class="font-medium">{{ date('M d, Y', strtotime('+1 day')) }}</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Total Amount</p>
                                    <p class="text-lg font-bold text-yellow-600">৳750</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition duration-200">
                                        View Details
                                    </button>
                                    <button class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200 transition duration-200">
                                        Collect Payment
                                    </button>
                                    <button class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm hover:bg-red-200 transition duration-200">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- No Results State -->
                        <div class="p-12 text-center text-gray-500" style="display: none;">
                            <div class="text-4xl mb-4">🔍</div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">No Bookings Found</h3>
                            <p class="text-gray-600">Try adjusting your search criteria or create a new booking.</p>
                            <button class="mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                                Create New Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('ticket-seller.booking') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
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
                    
                    <form method="POST" action="{{ route('ticket-seller.search.post') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search By</label>
                            <select name="search_by" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="pnr" {{ (old('search_by', $request->search_by ?? '') == 'pnr') ? 'selected' : '' }}>PNR Number</option>
                                <option value="phone" {{ (old('search_by', $request->search_by ?? '') == 'phone') ? 'selected' : '' }}>Phone Number</option>
                                <option value="name" {{ (old('search_by', $request->search_by ?? '') == 'name') ? 'selected' : '' }}>Passenger Name</option>
                                <option value="email" {{ (old('search_by', $request->search_by ?? '') == 'email') ? 'selected' : '' }}>Email Address</option>
                                <option value="id" {{ (old('search_by', $request->search_by ?? '') == 'id') ? 'selected' : '' }}>ID Number</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Value</label>
                            <input type="text" name="search_value" value="{{ old('search_value', $request->search_value ?? '') }}" placeholder="Enter PNR, phone, name, etc." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date (Optional)</label>
                            <input type="date" name="journey_date" value="{{ old('journey_date', $request->journey_date ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Booking Status</label>
                            <select name="booking_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="all" {{ (old('booking_status', $request->booking_status ?? '') == 'all') ? 'selected' : '' }}>All Status</option>
                                <option value="confirmed" {{ (old('booking_status', $request->booking_status ?? '') == 'confirmed') ? 'selected' : '' }}>Confirmed</option>
                                <option value="pending" {{ (old('booking_status', $request->booking_status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="cancelled" {{ (old('booking_status', $request->booking_status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ (old('booking_status', $request->booking_status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
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
                            <a href="{{ route('ticket-seller.search.quick', 'today') }}" class="w-full text-left bg-blue-50 text-blue-700 p-3 rounded-lg hover:bg-blue-100 transition duration-200 block">
                                📋 Today's Bookings
                            </a>
                            <a href="{{ route('ticket-seller.search.quick', 'recent') }}" class="w-full text-left bg-green-50 text-green-700 p-3 rounded-lg hover:bg-green-100 transition duration-200 block">
                                ✅ Recent Confirmations
                            </a>
                            <a href="{{ route('ticket-seller.search.quick', 'pending') }}" class="w-full text-left bg-yellow-50 text-yellow-700 p-3 rounded-lg hover:bg-yellow-100 transition duration-200 block">
                                ⏳ Pending Payments
                            </a>
                            <a href="{{ route('ticket-seller.search.quick', 'cancelled') }}" class="w-full text-left bg-red-50 text-red-700 p-3 rounded-lg hover:bg-red-100 transition duration-200 block">
                                ❌ Cancelled Bookings
                            </a>
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
                            @if(isset($bookings))
                                <span class="text-sm text-gray-600">{{ $bookings->total() }} bookings found</span>
                            @else
                                <span class="text-sm text-gray-600">0 bookings found</span>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @if(isset($bookings) && $bookings->count() > 0)
                            @foreach($bookings as $booking)
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800">PNR: {{ $booking->booking_reference }}</h3>
                                        <p class="text-sm text-gray-600">
                                            @if($booking->bookingPassengers->first())
                                                Passenger: {{ $booking->bookingPassengers->first()->passenger_name }} • 
                                            @endif
                                            Phone: {{ $booking->bookingPassengers->first()->id_number ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($booking->booking_status == 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->booking_status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Route</p>
                                        <p class="font-medium">
                                            {{ $booking->fromStation->station_name ?? 'N/A' }} → 
                                            {{ $booking->toStation->station_name ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Train</p>
                                        <p class="font-medium">
                                            {{ $booking->trainSchedule->train->train_name ?? 'N/A' }} 
                                            (#{{ $booking->trainSchedule->train->train_number ?? 'N/A' }})
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Journey Date</p>
                                        <p class="font-medium">{{ $booking->journey_date->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Amount</p>
                                        <p class="text-lg font-bold 
                                            @if($booking->payment_status == 'paid') text-green-600
                                            @elseif($booking->payment_status == 'pending') text-yellow-600
                                            @else text-gray-600
                                            @endif">
                                            ৳{{ number_format($booking->total_amount, 2) }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition duration-200">
                                            View Details
                                        </button>
                                        <button class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200 transition duration-200">
                                            Print Ticket
                                        </button>
                                        @if($booking->booking_status != 'cancelled')
                                            @if($booking->payment_status == 'pending')
                                                <button class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200 transition duration-200">
                                                    Collect Payment
                                                </button>
                                            @else
                                                <button class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm hover:bg-yellow-200 transition duration-200">
                                                    Modify
                                                </button>
                                            @endif
                                            <button class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm hover:bg-red-200 transition duration-200">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Pagination -->
                            @if($bookings->hasPages())
                            <div class="p-6">
                                {{ $bookings->links() }}
                            </div>
                            @endif
                        @else
                            <!-- No Results State -->
                            <div class="p-12 text-center text-gray-500">
                                <div class="text-4xl mb-4">🔍</div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">No Bookings Found</h3>
                                <p class="text-gray-600">Try adjusting your search criteria or create a new booking.</p>
                                <a href="{{ route('ticket-seller.booking') }}" class="mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200 inline-block">
                                    Create New Booking
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'My Bookings - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">🎫 My Bookings</h1>
            <p class="text-gray-600">View and manage all your train ticket bookings</p>
        </div>

        @if($bookings->count() > 0)
        <!-- Bookings List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Reference</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Train</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passengers</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->booking_reference }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->trainSchedule->train->train_name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">#{{ $booking->trainSchedule->train->train_number ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->fromStation->station_name ?? 'N/A' }} → {{ $booking->toStation->station_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->journey_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->total_passengers }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ৳{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($booking->booking_status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                                <div class="text-sm text-gray-500">{{ ucfirst($booking->payment_status) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-green-600 hover:text-green-900">View</a>
                                @if($booking->booking_status === 'confirmed' && $booking->payment_status === 'paid')
                                <a href="#" class="ml-3 text-blue-600 hover:text-blue-900">Download</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- No Bookings State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-6xl mb-6">🎫</div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">No Bookings Yet</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                You haven't made any train bookings yet. Start by searching for trains and booking your first journey!
            </p>
            <a href="{{ route('search.trains') }}" class="bg-gradient-to-r from-green-600 to-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-green-700 hover:to-red-700 transition duration-200">
                🔍 Search Trains
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
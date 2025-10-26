@extends('layouts.railway')

@section('title', 'Ticket Details - Ticket Seller')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🎫 Ticket Details</h1>
                    <p class="text-gray-600 mt-2">Preview ticket before printing</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('ticket-seller.print') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Print
                    </a>
                </div>
            </div>
        </div>

        <!-- Ticket Preview -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="border-2 border-gray-300 rounded-lg p-6">
                <!-- Ticket Header -->
                <div class="text-center border-b border-gray-300 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Bangladesh Railway</h2>
                    <p class="text-gray-600">E-Ticket Confirmation</p>
                </div>

                <!-- Booking Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Booking Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">PNR Number:</span>
                                <span class="font-medium">{{ $booking->booking_reference }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking Date:</span>
                                <span class="font-medium">{{ $booking->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking Status:</span>
                                <span class="font-medium 
                                    @if($booking->booking_status == 'confirmed') text-green-600
                                    @elseif($booking->booking_status == 'pending') text-yellow-600
                                    @elseif($booking->booking_status == 'cancelled') text-red-600
                                    @else text-gray-600
                                    @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="font-medium 
                                    @if($booking->payment_status == 'paid') text-green-600
                                    @elseif($booking->payment_status == 'pending') text-yellow-600
                                    @else text-gray-600
                                    @endif">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Journey Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Route:</span>
                                <span class="font-medium">
                                    {{ $booking->fromStation->station_name ?? 'N/A' }} → 
                                    {{ $booking->toStation->station_name ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Train:</span>
                                <span class="font-medium">
                                    {{ $booking->trainSchedule->train->train_name ?? 'N/A' }} 
                                    (#{{ $booking->trainSchedule->train->train_number ?? 'N/A' }})
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Journey Date:</span>
                                <span class="font-medium">{{ $booking->journey_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Departure:</span>
                                <span class="font-medium">{{ $booking->trainSchedule->departure_time->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Passenger Information</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Age</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Type</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Number</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Seat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($booking->bookingPassengers as $passenger)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $passenger->passenger_name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $passenger->age }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ ucfirst($passenger->gender) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">
                                        @if($passenger->id_type == 'nid')
                                            National ID
                                        @elseif($passenger->id_type == 'passport')
                                            Passport
                                        @elseif($passenger->id_type == 'birth_certificate')
                                            Birth Certificate
                                        @else
                                            {{ ucfirst($passenger->id_type) }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $passenger->id_number }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">
                                        {{ $passenger->seat->coach->coach_number ?? 'N/A' }}-{{ $passenger->seat->seat_number ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Fare Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Fare Details</h3>
                    <div class="max-w-xs ml-auto">
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Base Fare:</span>
                            <span>৳{{ number_format($booking->total_amount - 20 - ($booking->total_amount * 0.05), 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">VAT (5%):</span>
                            <span>৳{{ number_format($booking->total_amount * 0.05, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Service Charge:</span>
                            <span>৳20.00</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-300 font-bold">
                            <span>Total Amount:</span>
                            <span class="text-green-600">৳{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-center space-x-4 pt-4 border-t border-gray-300">
                    <a href="{{ route('ticket-seller.print.ticket', $booking->id) }}" target="_blank" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                        🖨️ Print Ticket
                    </a>
                    <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                        🖨️ Print This Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
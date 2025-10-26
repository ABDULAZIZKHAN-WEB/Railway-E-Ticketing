@extends('layouts.railway')

@section('title', 'Cash Report - Ticket Seller')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">💰 Cash Report</h1>
                    <p class="text-gray-600 mt-2">Daily cash collection and transaction summary</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        📥 Export Report
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cash Summary -->
            <div class="lg:col-span-2">
                <!-- Date Filter -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">📅 Filter Report</h2>
                    <form method="POST" action="{{ route('ticket-seller.cash-report.post') }}" class="flex flex-wrap gap-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ $startDate ?? date('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ $endDate ?? date('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="self-end">
                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Today's Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">📊 Cash Summary</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">৳{{ number_format($totalCashCollected ?? 12500, 2) }}</div>
                            <div class="text-sm text-gray-600">Cash Collected</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $totalTicketsSold ?? 45 }}</div>
                            <div class="text-sm text-gray-600">Tickets Sold</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">৳{{ number_format($averageSale ?? 278, 2) }}</div>
                            <div class="text-sm text-gray-600">Average Sale</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600">{{ $pendingTransactions ?? 3 }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                    </div>

                    <!-- Hourly Breakdown -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hour</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cash</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Card</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($hourlyData) && count($hourlyData) > 0)
                                    @foreach($hourlyData as $hourData)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hourData['hour'] }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hourData['tickets'] }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-green-600">৳{{ number_format($hourData['cash'], 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-600">৳{{ number_format($hourData['card'], 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">৳{{ number_format($hourData['total'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">
                                            No transaction data available for the selected period
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">💳 Transaction Details</h2>
                    
                    <div class="space-y-4">
                        @if(isset($bookings) && count($bookings) > 0)
                            @foreach($bookings->take(10) as $booking)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-800">
                                            {{ $booking->payment_status === 'paid' ? 'Cash' : 'Pending' }} Transaction #{{ $booking->id }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            PNR: {{ $booking->booking_reference }} • {{ $booking->created_at->format('g:i A') }}
                                        </p>
                                    </div>
                                    <span class="text-lg font-bold 
                                        @if($booking->payment_status === 'paid') text-green-600
                                        @else text-yellow-600
                                        @endif">
                                        ৳{{ number_format($booking->total_amount, 2) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-700">
                                    <p><strong>Customer:</strong> 
                                        @if($booking->bookingPassengers->first())
                                            {{ $booking->bookingPassengers->first()->passenger_name }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Route:</strong> 
                                        {{ $booking->fromStation->station_name ?? 'N/A' }} → 
                                        {{ $booking->toStation->station_name ?? 'N/A' }}
                                    </p>
                                    <p><strong>Payment:</strong> 
                                        @if($booking->payment_status === 'paid')
                                            Cash
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No transactions found for the selected period</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cash Management -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">💰 Cash Management</h2>
                    
                    <div class="space-y-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="font-semibold text-green-800 mb-2">Opening Balance</h3>
                            <p class="text-2xl font-bold text-green-600">৳{{ number_format($openingBalance ?? 5000, 2) }}</p>
                            <p class="text-sm text-green-700">Started at 8:00 AM</p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 mb-2">Cash Collected</h3>
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($totalCashCollected ?? 12500, 2) }}</p>
                            <p class="text-sm text-blue-700">From {{ $totalTicketsSold ?? 45 }} transactions</p>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h3 class="font-semibold text-purple-800 mb-2">Current Balance</h3>
                            <p class="text-2xl font-bold text-purple-600">৳{{ number_format($currentBalance ?? 17500, 2) }}</p>
                            <p class="text-sm text-purple-700">Ready for deposit</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                            💰 Record Cash Deposit
                        </button>
                        <button class="w-full bg-blue-100 text-blue-700 py-3 px-4 rounded-lg hover:bg-blue-200 transition duration-200">
                            📊 Generate Shift Report
                        </button>
                        <button class="w-full bg-red-100 text-red-700 py-3 px-4 rounded-lg hover:bg-red-200 transition duration-200">
                            🔚 End Shift
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">📈 Quick Stats</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shift Duration</span>
                            <span class="font-medium">6h 30m</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Avg. per Hour</span>
                            <span class="font-medium">৳{{ number_format(($totalCashCollected ?? 12500) / 6.5, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Cash vs Card</span>
                            <span class="font-medium">70% / 30%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Refunds Issued</span>
                            <span class="font-medium">2 (৳1,200)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
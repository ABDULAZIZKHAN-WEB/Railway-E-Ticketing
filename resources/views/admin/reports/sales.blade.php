@extends('layouts.railway')

@section('title', 'Sales Reports - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">💰 Sales Reports</h1>
                    <p class="text-gray-600 mt-2">Revenue analysis and financial reports</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.reports') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Reports
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        📥 Export Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Sales Data -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Revenue Trend (Last 30 Days)</h2>
            <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <div class="text-4xl mb-2">📊</div>
                    <p>Chart visualization would be here</p>
                    <p class="text-sm">Integration with Chart.js or similar</p>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Sales Summary</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sales (৳)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number of Transactions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Ticket Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($salesData as $sale)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">৳{{ number_format($sale->total_sales, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
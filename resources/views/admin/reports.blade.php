@extends('layouts.railway')

@section('title', 'Reports & Analytics - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📊 Reports & Analytics</h1>
                    <p class="text-gray-600 mt-2">System reports and business analytics</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        📥 Export Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-lg font-semibold text-gray-800">Revenue Reports</h3>
                    <p class="text-sm text-gray-600 mt-2">Daily, monthly, and yearly revenue analysis</p>
                    <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition duration-200">
                        Generate Report
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center">
                    <div class="text-4xl mb-4">🎫</div>
                    <h3 class="text-lg font-semibold text-gray-800">Booking Reports</h3>
                    <p class="text-sm text-gray-600 mt-2">Booking statistics and trends</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition duration-200">
                        Generate Report
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center">
                    <div class="text-4xl mb-4">🚄</div>
                    <h3 class="text-lg font-semibold text-gray-800">Train Performance</h3>
                    <p class="text-sm text-gray-600 mt-2">Punctuality and occupancy rates</p>
                    <button class="mt-4 bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition duration-200">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Sample Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">📈 Revenue Trend (Last 30 Days)</h2>
                <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <div class="text-4xl mb-2">📊</div>
                        <p>Chart visualization would be here</p>
                        <p class="text-sm">Integration with Chart.js or similar</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🎯 Key Metrics</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Total Bookings (This Month)</span>
                        <span class="text-2xl font-bold text-green-600">1,234</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Average Ticket Price</span>
                        <span class="text-2xl font-bold text-blue-600">৳750</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Occupancy Rate</span>
                        <span class="text-2xl font-bold text-purple-600">78%</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Customer Satisfaction</span>
                        <span class="text-2xl font-bold text-yellow-600">4.2/5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
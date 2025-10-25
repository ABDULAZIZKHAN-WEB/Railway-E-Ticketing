@extends('layouts.railway')

@section('title', 'Train Schedule - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📋 Train Schedule</h1>
                    <p class="text-gray-600 mt-2">Dhaka Railway Station - {{ date('l, F d, Y') }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        🔄 Refresh Schedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Schedule Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6">
                    <button class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        All Trains
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Arrivals
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Departures
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Delayed
                    </button>
                </nav>
            </div>

            <!-- Schedule Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Train</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Suborno Express</div>
                                    <div class="text-sm text-gray-500">#701</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Departure
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dhaka → Chittagong</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">07:30 AM</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Platform 1</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    On Time
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900">Update</button>
                                    <button class="text-yellow-600 hover:text-yellow-900">Delay</button>
                                    <button class="text-green-600 hover:text-green-900">Announce</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Mohanagar Godhuli</div>
                                    <div class="text-sm text-gray-500">#703</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Arrival
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chittagong → Dhaka</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15:30 PM</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Platform 2</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Delayed 15 min
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900">Update</button>
                                    <button class="text-yellow-600 hover:text-yellow-900">Delay</button>
                                    <button class="text-green-600 hover:text-green-900">Announce</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">📢</div>
                    <h3 class="font-semibold text-gray-800">Make Announcement</h3>
                </div>
            </button>
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">⏰</div>
                    <h3 class="font-semibold text-gray-800">Report Delay</h3>
                </div>
            </button>
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">🔧</div>
                    <h3 class="font-semibold text-gray-800">Platform Status</h3>
                </div>
            </button>
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">📊</div>
                    <h3 class="font-semibold text-gray-800">Daily Report</h3>
                </div>
            </button>
        </div>
    </div>
</div>
@endsection
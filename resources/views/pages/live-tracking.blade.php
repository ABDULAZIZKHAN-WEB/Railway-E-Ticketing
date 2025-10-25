@extends('layouts.railway')

@section('title', 'Live Train Tracking - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">🚄 Live Train Tracking</h1>
            <p class="text-gray-600">Track your train's real-time location and get live updates on arrival times.</p>
        </div>

        <!-- Search Train -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Search Train</h2>
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Train Number</label>
                    <input type="text" placeholder="e.g., 701" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PNR Number (Optional)</label>
                    <input type="text" placeholder="Your booking PNR" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-green-700 hover:to-red-700 transition duration-200">
                        🔍 Track Train
                    </button>
                </div>
            </form>
        </div>

        <!-- Demo Tracking (Mock Data) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Map Area -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📍 Live Location</h3>
                <div class="bg-gray-100 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <div class="text-4xl mb-4">🗺️</div>
                        <p class="text-lg font-medium">Interactive Map</p>
                        <p class="text-sm">Google Maps integration will be displayed here</p>
                        <p class="text-xs mt-2">API Key: AIzaSyAavHi-ZMkfFfm4ktfABZFtDKHmEOrrGrI</p>
                    </div>
                </div>
            </div>

            <!-- Train Details -->
            <div class="space-y-6">
                <!-- Current Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🚄 Train Status</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Train Name</span>
                            <span class="font-semibold">Suborno Express (701)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Current Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Running On Time
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Current Location</span>
                            <span class="font-semibold">Approaching Comilla</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Speed</span>
                            <span class="font-semibold">85 km/h</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Next Station</span>
                            <span class="font-semibold">Chittagong (ETA: 2:45 PM)</span>
                        </div>
                    </div>
                </div>

                <!-- Route Progress -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🛤️ Route Progress</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-medium">Dhaka</span>
                                    <span class="text-sm text-gray-500">07:30 AM ✓</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-medium">Comilla</span>
                                    <span class="text-sm text-gray-500">11:15 AM ✓</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3 animate-pulse"></div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-medium">Chittagong</span>
                                    <span class="text-sm text-yellow-600">2:45 PM (Expected)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-800 mb-2">📢 Live Updates</h4>
                    <div class="text-sm text-blue-700 space-y-1">
                        <p>• Train is running on schedule</p>
                        <p>• No delays reported</p>
                        <p>• Weather conditions: Clear</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Trains -->
        <div class="mt-12 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">🔥 Track Popular Trains</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                    <h4 class="font-medium text-gray-800 mb-2">Suborno Express (701)</h4>
                    <p class="text-sm text-gray-600 mb-2">Dhaka → Chittagong</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        On Time
                    </span>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                    <h4 class="font-medium text-gray-800 mb-2">Mohanagar Godhuli (703)</h4>
                    <p class="text-sm text-gray-600 mb-2">Dhaka → Chittagong</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        5 min delay
                    </span>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:bg-green-50 transition duration-200 cursor-pointer">
                    <h4 class="font-medium text-gray-800 mb-2">Silk City Express (711)</h4>
                    <p class="text-sm text-gray-600 mb-2">Dhaka → Rajshahi</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        On Time
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
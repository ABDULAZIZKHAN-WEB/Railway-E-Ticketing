@extends('layouts.railway')

@section('title', 'Platform Status - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🔧 Platform Status Management</h1>
                    <p class="text-gray-600 mt-2">Monitor and manage platform availability and maintenance</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        🔄 Refresh Status
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Platform Overview -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Platform Overview</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Platform 1 -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Platform 1</h3>
                                    <p class="text-sm text-gray-600">Main Express Platform</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Current Train:</span>
                                    <span class="font-medium">None</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Next Arrival:</span>
                                    <span class="font-medium">Suborno Express - 07:30 AM</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Capacity:</span>
                                    <span class="font-medium">12 Coaches</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Last Maintenance:</span>
                                    <span class="font-medium">Oct 20, 2025</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button class="flex-1 bg-yellow-100 text-yellow-700 py-2 px-3 rounded text-sm hover:bg-yellow-200 transition duration-200">
                                    🔧 Maintenance
                                </button>
                                <button class="flex-1 bg-red-100 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-200 transition duration-200">
                                    🚫 Block
                                </button>
                            </div>
                        </div>

                        <!-- Platform 2 -->
                        <div class="border border-red-200 rounded-lg p-6 bg-red-50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Platform 2</h3>
                                    <p class="text-sm text-gray-600">Local Train Platform</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Occupied
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Current Train:</span>
                                    <span class="font-medium text-red-700">Mohanagar Godhuli (#703)</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Departure:</span>
                                    <span class="font-medium">15:45 PM (Delayed)</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Capacity:</span>
                                    <span class="font-medium">10 Coaches</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Boarding Status:</span>
                                    <span class="font-medium text-red-700">In Progress</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button class="flex-1 bg-blue-100 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-200 transition duration-200">
                                    📋 Details
                                </button>
                                <button class="flex-1 bg-green-100 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-200 transition duration-200">
                                    ✅ Clear
                                </button>
                            </div>
                        </div>

                        <!-- Platform 3 -->
                        <div class="border border-yellow-200 rounded-lg p-6 bg-yellow-50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Platform 3</h3>
                                    <p class="text-sm text-gray-600">Freight Platform</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Maintenance
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Maintenance Type:</span>
                                    <span class="font-medium">Track Repair</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Started:</span>
                                    <span class="font-medium">Oct 25, 6:00 AM</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Expected Completion:</span>
                                    <span class="font-medium">Oct 25, 4:00 PM</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Progress:</span>
                                    <span class="font-medium">75%</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button class="flex-1 bg-blue-100 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-200 transition duration-200">
                                    📋 Update
                                </button>
                                <button class="flex-1 bg-green-100 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-200 transition duration-200">
                                    ✅ Complete
                                </button>
                            </div>
                        </div>

                        <!-- Platform 4 -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Platform 4</h3>
                                    <p class="text-sm text-gray-600">Intercity Platform</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Current Train:</span>
                                    <span class="font-medium">None</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Next Arrival:</span>
                                    <span class="font-medium">Turna Nishita - 23:00 PM</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Capacity:</span>
                                    <span class="font-medium">8 Coaches</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Last Cleaned:</span>
                                    <span class="font-medium">2 hours ago</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button class="flex-1 bg-yellow-100 text-yellow-700 py-2 px-3 rounded text-sm hover:bg-yellow-200 transition duration-200">
                                    🔧 Maintenance
                                </button>
                                <button class="flex-1 bg-red-100 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-200 transition duration-200">
                                    🚫 Block
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Platform Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <button class="bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200">
                            <div class="text-2xl mb-2">🔄</div>
                            <div class="text-sm font-medium">Refresh All</div>
                        </button>
                        <button class="bg-yellow-50 text-yellow-700 p-4 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <div class="text-2xl mb-2">🔧</div>
                            <div class="text-sm font-medium">Schedule Maintenance</div>
                        </button>
                        <button class="bg-red-50 text-red-700 p-4 rounded-lg hover:bg-red-100 transition duration-200">
                            <div class="text-2xl mb-2">🚨</div>
                            <div class="text-sm font-medium">Emergency Block</div>
                        </button>
                        <button class="bg-green-50 text-green-700 p-4 rounded-lg hover:bg-green-100 transition duration-200">
                            <div class="text-2xl mb-2">📊</div>
                            <div class="text-sm font-medium">Generate Report</div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Platform Control Panel -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Platform Control</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Platform</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Platform 1</option>
                                <option>Platform 2</option>
                                <option>Platform 3</option>
                                <option>Platform 4</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Change Status</option>
                                <option>Schedule Maintenance</option>
                                <option>Assign Train</option>
                                <option>Clear Platform</option>
                                <option>Emergency Block</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add notes about the action..."></textarea>
                        </div>

                        <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            Execute Action
                        </button>
                    </div>
                </div>

                <!-- Platform Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Today's Statistics</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Arrivals</span>
                            <span class="text-2xl font-bold text-blue-600">12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Departures</span>
                            <span class="text-2xl font-bold text-green-600">11</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Maintenance Hours</span>
                            <span class="text-2xl font-bold text-yellow-600">6</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Utilization Rate</span>
                            <span class="text-2xl font-bold text-purple-600">78%</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-3">Platform Efficiency</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Platform 1</span>
                                <span class="font-medium">95%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Platform 2</span>
                                <span class="font-medium">87%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Platform 3</span>
                                <span class="font-medium">45%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Platform 4</span>
                                <span class="font-medium">92%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
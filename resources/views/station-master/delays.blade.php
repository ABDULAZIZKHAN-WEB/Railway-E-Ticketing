@extends('layouts.railway')

@section('title', 'Update Delays - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">⏰ Update Train Delays</h1>
                    <p class="text-gray-600 mt-2">Report and manage train delays</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Report New Delay -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">📝 Report New Delay</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Train</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Select a train...</option>
                            <option>Suborno Express (#701)</option>
                            <option>Mohanagar Godhuli (#703)</option>
                            <option>Turna Nishita (#705)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delay Duration</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="number" placeholder="Hours" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <input type="number" placeholder="Minutes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Delay</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Select reason...</option>
                            <option>Technical Issues</option>
                            <option>Weather Conditions</option>
                            <option>Signal Problems</option>
                            <option>Track Maintenance</option>
                            <option>Passenger Issues</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Provide additional details about the delay..."></textarea>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                            Report Delay
                        </button>
                        <button type="button" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            Send Notification
                        </button>
                    </div>
                </form>
            </div>

            <!-- Current Delays -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🚨 Current Delays</h2>
                <div class="space-y-4">
                    <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-medium text-gray-800">Mohanagar Godhuli (#703)</h4>
                                <p class="text-sm text-gray-600">Chittagong → Dhaka</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                15 min delay
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">
                            <strong>Reason:</strong> Signal problems at junction
                        </p>
                        <div class="flex space-x-2">
                            <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Update</button>
                            <button class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Resolve</button>
                            <button class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Notify Passengers</button>
                        </div>
                    </div>

                    <div class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-medium text-gray-800">Silk City Express (#711)</h4>
                                <p class="text-sm text-gray-600">Dhaka → Rajshahi</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                5 min delay
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">
                            <strong>Reason:</strong> Passenger boarding delay
                        </p>
                        <div class="flex space-x-2">
                            <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Update</button>
                            <button class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Resolve</button>
                            <button class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Notify Passengers</button>
                        </div>
                    </div>

                    <div class="text-center py-8 text-gray-500">
                        <div class="text-3xl mb-2">✅</div>
                        <p>All other trains are running on time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
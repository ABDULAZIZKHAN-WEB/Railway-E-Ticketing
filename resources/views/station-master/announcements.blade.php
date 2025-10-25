@extends('layouts.railway')

@section('title', 'Station Announcements - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📢 Station Announcements</h1>
                    <p class="text-gray-600 mt-2">Create and manage station announcements for passengers</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        🔊 Test PA System
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Create New Announcement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">📝 Create New Announcement</h2>
                
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Type</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>General Information</option>
                            <option>Train Arrival</option>
                            <option>Train Departure</option>
                            <option>Train Delay</option>
                            <option>Platform Change</option>
                            <option>Emergency Alert</option>
                            <option>Service Update</option>
                            <option>Safety Reminder</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Related Train (Optional)</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Select a train...</option>
                            <option>Suborno Express (#701)</option>
                            <option>Mohanagar Godhuli (#703)</option>
                            <option>Turna Nishita (#705)</option>
                            <option>Silk City Express (#711)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Platform (Optional)</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>All Platforms</option>
                            <option>Platform 1</option>
                            <option>Platform 2</option>
                            <option>Platform 3</option>
                            <option>Platform 4</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm">English</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm">বাংলা (Bengali)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (English)</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your announcement message in English..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (Bengali)</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="বাংলায় আপনার ঘোষণার বার্তা লিখুন..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Normal</option>
                            <option>High</option>
                            <option>Emergency</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repeat Options</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>Announce Once</option>
                                    <option>Repeat 2 times</option>
                                    <option>Repeat 3 times</option>
                                    <option>Repeat 5 times</option>
                                </select>
                            </div>
                            <div>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>No Interval</option>
                                    <option>30 seconds interval</option>
                                    <option>1 minute interval</option>
                                    <option>2 minutes interval</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="button" class="flex-1 bg-blue-100 text-blue-700 py-3 px-4 rounded-lg hover:bg-blue-200 transition duration-200">
                            🔊 Preview
                        </button>
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            📢 Make Announcement
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Announcements & Quick Templates -->
            <div class="space-y-6">
                <!-- Quick Templates -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">⚡ Quick Templates</h2>
                    
                    <div class="space-y-3">
                        <button class="w-full text-left bg-green-50 text-green-700 p-4 rounded-lg hover:bg-green-100 transition duration-200">
                            <div class="font-medium">Train Arrival</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] from [ORIGIN] is arriving at Platform [X]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200">
                            <div class="font-medium">Train Departure</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] to [DESTINATION] is departing from Platform [X]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-yellow-50 text-yellow-700 p-4 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <div class="font-medium">Train Delay</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] is delayed by [TIME] due to [REASON]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-red-50 text-red-700 p-4 rounded-lg hover:bg-red-100 transition duration-200">
                            <div class="font-medium">Platform Change</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] platform changed from [OLD] to [NEW]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-purple-50 text-purple-700 p-4 rounded-lg hover:bg-purple-100 transition duration-200">
                            <div class="font-medium">Safety Reminder</div>
                            <div class="text-sm opacity-75">"Please stand behind the yellow line for your safety"</div>
                        </button>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">📋 Recent Announcements</h2>
                    
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-800">Train Arrival - Suborno Express</h4>
                                    <p class="text-sm text-gray-600">Platform 1 • 2 minutes ago</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">
                                "Suborno Express from Chittagong is arriving at Platform 1"
                            </p>
                            <div class="flex space-x-2">
                                <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Repeat</button>
                                <button class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Edit</button>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-800">Train Delay - Mohanagar Godhuli</h4>
                                    <p class="text-sm text-gray-600">All Platforms • 15 minutes ago</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Repeated 3x
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">
                                "Mohanagar Godhuli is delayed by 15 minutes due to signal problems"
                            </p>
                            <div class="flex space-x-2">
                                <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Repeat</button>
                                <button class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Edit</button>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-800">Safety Reminder</h4>
                                    <p class="text-sm text-gray-600">All Platforms • 1 hour ago</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Scheduled
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">
                                "Please stand behind the yellow line and allow passengers to exit first"
                            </p>
                            <div class="flex space-x-2">
                                <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Repeat</button>
                                <button class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'Create Announcement - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Create New Announcement</h1>
                    <p class="text-gray-600 mt-2">Create a new station announcement</p>
                </div>
                <a href="{{ route('station-master.announcements') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    ← Back to Announcements
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('station-master.announcements.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Type</label>
                        <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="General Information">General Information</option>
                            <option value="Train Arrival">Train Arrival</option>
                            <option value="Train Departure">Train Departure</option>
                            <option value="Train Delay">Train Delay</option>
                            <option value="Platform Change">Platform Change</option>
                            <option value="Emergency Alert">Emergency Alert</option>
                            <option value="Service Update">Service Update</option>
                            <option value="Safety Reminder">Safety Reminder</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Related Train (Optional)</label>
                        <select name="train_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a train...</option>
                            <option value="Suborno Express (#701)">Suborno Express (#701)</option>
                            <option value="Mohanagar Godhuli (#703)">Mohanagar Godhuli (#703)</option>
                            <option value="Turna Nishita (#705)">Turna Nishita (#705)</option>
                            <option value="Silk City Express (#711)">Silk City Express (#711)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Platform (Optional)</label>
                        <select name="platform" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Platforms</option>
                            <option value="Platform 1">Platform 1</option>
                            <option value="Platform 2">Platform 2</option>
                            <option value="Platform 3">Platform 3</option>
                            <option value="Platform 4">Platform 4</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (English)</label>
                        <textarea name="message_en" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your announcement message in English..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (Bengali)</label>
                        <textarea name="message_bn" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="বাংলায় আপনার ঘোষণার বার্তা লিখুন..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
                        <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repeat Options</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select name="repeat_times" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1">Announce Once</option>
                                    <option value="2">Repeat 2 times</option>
                                    <option value="3">Repeat 3 times</option>
                                    <option value="5">Repeat 5 times</option>
                                </select>
                            </div>
                            <div>
                                <select name="repeat_interval" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="0">No Interval</option>
                                    <option value="30">30 seconds interval</option>
                                    <option value="60">1 minute interval</option>
                                    <option value="120">2 minutes interval</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('station-master.announcements') }}" class="bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                            Create Announcement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
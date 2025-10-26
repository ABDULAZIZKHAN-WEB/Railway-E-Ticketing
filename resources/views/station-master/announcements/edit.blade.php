@extends('layouts.railway')

@section('title', 'Edit Announcement - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Announcement</h1>
                    <p class="text-gray-600 mt-2">Update announcement details</p>
                </div>
                <a href="{{ route('station-master.announcements') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    ← Back to Announcements
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('station-master.announcements.update', $announcement) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Type</label>
                        <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="General Information" {{ old('type', $announcement->type) == 'General Information' ? 'selected' : '' }}>General Information</option>
                            <option value="Train Arrival" {{ old('type', $announcement->type) == 'Train Arrival' ? 'selected' : '' }}>Train Arrival</option>
                            <option value="Train Departure" {{ old('type', $announcement->type) == 'Train Departure' ? 'selected' : '' }}>Train Departure</option>
                            <option value="Train Delay" {{ old('type', $announcement->type) == 'Train Delay' ? 'selected' : '' }}>Train Delay</option>
                            <option value="Platform Change" {{ old('type', $announcement->type) == 'Platform Change' ? 'selected' : '' }}>Platform Change</option>
                            <option value="Emergency Alert" {{ old('type', $announcement->type) == 'Emergency Alert' ? 'selected' : '' }}>Emergency Alert</option>
                            <option value="Service Update" {{ old('type', $announcement->type) == 'Service Update' ? 'selected' : '' }}>Service Update</option>
                            <option value="Safety Reminder" {{ old('type', $announcement->type) == 'Safety Reminder' ? 'selected' : '' }}>Safety Reminder</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Related Train (Optional)</label>
                        <select name="train_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a train...</option>
                            <option value="Suborno Express (#701)" {{ old('train_number', $announcement->train_number) == 'Suborno Express (#701)' ? 'selected' : '' }}>Suborno Express (#701)</option>
                            <option value="Mohanagar Godhuli (#703)" {{ old('train_number', $announcement->train_number) == 'Mohanagar Godhuli (#703)' ? 'selected' : '' }}>Mohanagar Godhuli (#703)</option>
                            <option value="Turna Nishita (#705)" {{ old('train_number', $announcement->train_number) == 'Turna Nishita (#705)' ? 'selected' : '' }}>Turna Nishita (#705)</option>
                            <option value="Silk City Express (#711)" {{ old('train_number', $announcement->train_number) == 'Silk City Express (#711)' ? 'selected' : '' }}>Silk City Express (#711)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Platform (Optional)</label>
                        <select name="platform" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Platforms</option>
                            <option value="Platform 1" {{ old('platform', $announcement->platform) == 'Platform 1' ? 'selected' : '' }}>Platform 1</option>
                            <option value="Platform 2" {{ old('platform', $announcement->platform) == 'Platform 2' ? 'selected' : '' }}>Platform 2</option>
                            <option value="Platform 3" {{ old('platform', $announcement->platform) == 'Platform 3' ? 'selected' : '' }}>Platform 3</option>
                            <option value="Platform 4" {{ old('platform', $announcement->platform) == 'Platform 4' ? 'selected' : '' }}>Platform 4</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (English)</label>
                        <textarea name="message_en" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your announcement message in English...">{{ old('message_en', $announcement->message_en) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Announcement Message (Bengali)</label>
                        <textarea name="message_bn" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="বাংলায় আপনার ঘোষণার বার্তা লিখুন...">{{ old('message_bn', $announcement->message_bn) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
                        <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="normal" {{ old('priority', $announcement->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ old('priority', $announcement->priority) == 'high' ? 'selected' : '' }}>High</option>
                            <option value="emergency" {{ old('priority', $announcement->priority) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repeat Options</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select name="repeat_times" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1" {{ old('repeat_times', $announcement->repeat_times) == 1 ? 'selected' : '' }}>Announce Once</option>
                                    <option value="2" {{ old('repeat_times', $announcement->repeat_times) == 2 ? 'selected' : '' }}>Repeat 2 times</option>
                                    <option value="3" {{ old('repeat_times', $announcement->repeat_times) == 3 ? 'selected' : '' }}>Repeat 3 times</option>
                                    <option value="5" {{ old('repeat_times', $announcement->repeat_times) == 5 ? 'selected' : '' }}>Repeat 5 times</option>
                                </select>
                            </div>
                            <div>
                                <select name="repeat_interval" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="0" {{ old('repeat_interval', $announcement->repeat_interval) == 0 ? 'selected' : '' }}>No Interval</option>
                                    <option value="30" {{ old('repeat_interval', $announcement->repeat_interval) == 30 ? 'selected' : '' }}>30 seconds interval</option>
                                    <option value="60" {{ old('repeat_interval', $announcement->repeat_interval) == 60 ? 'selected' : '' }}>1 minute interval</option>
                                    <option value="120" {{ old('repeat_interval', $announcement->repeat_interval) == 120 ? 'selected' : '' }}>2 minutes interval</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('station-master.announcements') }}" class="bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                            Update Announcement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
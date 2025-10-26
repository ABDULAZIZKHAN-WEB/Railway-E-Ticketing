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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" disabled>
                                    <span class="ml-2 text-sm">English</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" disabled>
                                    <span class="ml-2 text-sm">বাংলা (Bengali)</span>
                                </label>
                            </div>
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

                        <div class="flex space-x-4">
                            <button type="button" class="flex-1 bg-blue-100 text-blue-700 py-3 px-4 rounded-lg hover:bg-blue-200 transition duration-200">
                                🔊 Preview
                            </button>
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                                📢 Make Announcement
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recent Announcements & Quick Templates -->
            <div class="space-y-6">
                <!-- Quick Templates -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">⚡ Quick Templates</h2>
                    
                    <div class="space-y-3">
                        <button class="w-full text-left bg-green-50 text-green-700 p-4 rounded-lg hover:bg-green-100 transition duration-200" onclick="fillTemplate('Train Arrival')">
                            <div class="font-medium">Train Arrival</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] from [ORIGIN] is arriving at Platform [X]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200" onclick="fillTemplate('Train Departure')">
                            <div class="font-medium">Train Departure</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] to [DESTINATION] is departing from Platform [X]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-yellow-50 text-yellow-700 p-4 rounded-lg hover:bg-yellow-100 transition duration-200" onclick="fillTemplate('Train Delay')">
                            <div class="font-medium">Train Delay</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] is delayed by [TIME] due to [REASON]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-red-50 text-red-700 p-4 rounded-lg hover:bg-red-100 transition duration-200" onclick="fillTemplate('Platform Change')">
                            <div class="font-medium">Platform Change</div>
                            <div class="text-sm opacity-75">"Train [NUMBER] platform changed from [OLD] to [NEW]"</div>
                        </button>
                        
                        <button class="w-full text-left bg-purple-50 text-purple-700 p-4 rounded-lg hover:bg-purple-100 transition duration-200" onclick="fillTemplate('Safety Reminder')">
                            <div class="font-medium">Safety Reminder</div>
                            <div class="text-sm opacity-75">"Please stand behind the yellow line for your safety"</div>
                        </button>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">📋 Recent Announcements</h2>
                    
                    <div class="space-y-4">
                        @forelse($announcements as $announcement)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $announcement->type }} - {{ $announcement->train_number ?? 'General' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $announcement->platform ?? 'All Platforms' }} • {{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($announcement->status === 'completed') bg-green-100 text-green-800
                                    @elseif($announcement->status === 'published') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">
                                "{{ $announcement->message_en }}"
                            </p>
                            <div class="flex space-x-2">
                                <form action="{{ route('station-master.announcements.publish', $announcement) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200">Repeat</button>
                                </form>
                                <a href="{{ route('station-master.announcements.edit', $announcement) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                                <form action="{{ route('station-master.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Delete</button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            No announcements found.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function fillTemplate(templateType) {
            let messageEn = '';
            let messageBn = '';
            
            switch(templateType) {
                case 'Train Arrival':
                    messageEn = 'Train [NUMBER] from [ORIGIN] is arriving at Platform [X]';
                    messageBn = 'ট্রেন [NUMBER] [ORIGIN] থেকে প্ল্যাটফর্ম [X] এ আসছে';
                    break;
                case 'Train Departure':
                    messageEn = 'Train [NUMBER] to [DESTINATION] is departing from Platform [X]';
                    messageBn = 'ট্রেন [NUMBER] [DESTINATION] এর উদ্দেশ্যে প্ল্যাটফর্ম [X] থেকে রওনা হচ্ছে';
                    break;
                case 'Train Delay':
                    messageEn = 'Train [NUMBER] is delayed by [TIME] due to [REASON]';
                    messageBn = 'ট্রেন [NUMBER] [REASON] এর কারণে [TIME] মিনিট দেরিতে আসবে';
                    break;
                case 'Platform Change':
                    messageEn = 'Train [NUMBER] platform changed from [OLD] to [NEW]';
                    messageBn = 'ট্রেন [NUMBER] এর প্ল্যাটফর্ম [OLD] থেকে [NEW] তে পরিবর্তন হয়েছে';
                    break;
                case 'Safety Reminder':
                    messageEn = 'Please stand behind the yellow line and allow passengers to exit first';
                    messageBn = 'অনুগ্রহ করে হলুদ লাইনের পিছনে দাঁড়ান এবং যাত্রীদের প্রথমে নামার সুযোগ দিন';
                    break;
            }
            
            document.querySelector('textarea[name="message_en"]').value = messageEn;
            document.querySelector('textarea[name="message_bn"]').value = messageBn;
            document.querySelector('select[name="type"]').value = templateType;
        }
    </script>
</div>
@endsection
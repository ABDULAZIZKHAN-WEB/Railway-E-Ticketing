@extends('layouts.railway')

@section('title', 'Station Master Dashboard - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Station Master Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">🚉 Station Master Dashboard</h1>
                    <p class="text-blue-100">Manage station operations and train schedules</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-sm text-blue-100">Station</div>
                        <div class="font-semibold">Chittagong Railway Station</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('station-master.schedule') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">📋</div>
                    <h3 class="font-semibold text-gray-800">Train Schedule</h3>
                    <p class="text-sm text-gray-600">View today's schedule</p>
                </div>
            </a>

            <a href="{{ route('station-master.delays') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">⏰</div>
                    <h3 class="font-semibold text-gray-800">Update Delays</h3>
                    <p class="text-sm text-gray-600">Report train delays</p>
                </div>
            </a>

            <a href="{{ route('station-master.platforms') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">🔧</div>
                    <h3 class="font-semibold text-gray-800">Platform Status</h3>
                    <p class="text-sm text-gray-600">Manage platforms</p>
                </div>
            </a>

            <a href="{{ route('station-master.announcements') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 group">
                <div class="text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-200">📢</div>
                    <h3 class="font-semibold text-gray-800">Announcements</h3>
                    <p class="text-sm text-gray-600">Make announcements</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Today's Train Schedule -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🚄 Today's Trains</h2>
                <div class="space-y-4">
                    @if(isset($todays_trains) && count($todays_trains) > 0)
                        @foreach($todays_trains as $train)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $train['train_name'] }} ({{ $train['train_number'] }})</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst($train['type']) }} • {{ $train['scheduled_time'] }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    @if($train['status'] == 'on_time')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            On Time
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Delayed
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Update Status</button>
                                <button class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">View Details</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No trains scheduled for today</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Station Operations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🔧 Station Operations</h2>
                
                <!-- Platform Status -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Platform Status</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $platforms = [
                                ['name' => 'Platform 1', 'status' => 'available'],
                                ['name' => 'Platform 2', 'status' => 'occupied'],
                                ['name' => 'Platform 3', 'status' => 'maintenance'],
                                ['name' => 'Platform 4', 'status' => 'available'],
                            ];
                        @endphp
                        
                        @foreach($platforms as $platform)
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">{{ $platform['name'] }}</span>
                                @if($platform['status'] == 'available')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @elseif($platform['status'] == 'occupied')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Occupied
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Maintenance
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('station-master.announcements') }}" class="w-full text-left bg-blue-50 text-blue-700 p-3 rounded-lg hover:bg-blue-100 transition duration-200 block">
                            📢 Make Station Announcement
                        </a>
                        <a href="{{ route('station-master.delays') }}" class="w-full text-left bg-yellow-50 text-yellow-700 p-3 rounded-lg hover:bg-yellow-100 transition duration-200 block">
                            ⏰ Report Train Delay
                        </a>
                        <button class="w-full text-left bg-green-50 text-green-700 p-3 rounded-lg hover:bg-green-100 transition duration-200">
                            📋 Generate Daily Report
                        </button>
                        <button class="w-full text-left bg-red-50 text-red-700 p-3 rounded-lg hover:bg-red-100 transition duration-200">
                            🚨 Emergency Alert
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
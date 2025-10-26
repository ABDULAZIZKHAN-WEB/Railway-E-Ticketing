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
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200" onclick="location.reload();">
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
                        @forelse($schedules as $schedule)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $schedule->train->train_name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">#{{ $schedule->train->train_number ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($schedule->route->start_station_id == 1) bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $schedule->route->start_station_id == 1 ? 'Departure' : 'Arrival' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $schedule->route->startStation->station_name ?? 'N/A' }} → {{ $schedule->route->endStation->station_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Platform {{ rand(1, 4) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($schedule->status === 'on_time') bg-green-100 text-green-800
                                    @elseif($schedule->status === 'delayed') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if($schedule->status === 'delayed')
                                        Delayed {{ $schedule->delay_minutes }} min
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900" onclick="openUpdateModal({{ $schedule->id }})">Update</button>
                                    <button class="text-yellow-600 hover:text-yellow-900" onclick="openDelayModal({{ $schedule->id }})">Delay</button>
                                    <button class="text-green-600 hover:text-green-900">Announce</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No schedules found for today.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <a href="{{ route('station-master.announcements') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">📢</div>
                    <h3 class="font-semibold text-gray-800">Make Announcement</h3>
                </div>
            </a>
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200" onclick="openDelayModal()">
                <div class="text-center">
                    <div class="text-3xl mb-2">⏰</div>
                    <h3 class="font-semibold text-gray-800">Report Delay</h3>
                </div>
            </button>
            <a href="{{ route('station-master.platforms') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">🔧</div>
                    <h3 class="font-semibold text-gray-800">Platform Status</h3>
                </div>
            </a>
            <button class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">📊</div>
                    <h3 class="font-semibold text-gray-800">Daily Report</h3>
                </div>
            </button>
        </div>
    </div>
    
    <!-- Update Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Train Status</h3>
            </div>
            <form id="updateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="on_time">On Time</option>
                            <option value="delayed">Delayed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delay Minutes (if delayed)</label>
                        <input type="number" name="delay_minutes" min="0" max="1440" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="closeModal('updateModal')">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delay Modal -->
    <div id="delayModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Report Train Delay</h3>
            </div>
            <form id="delayForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="schedule_id" id="delayScheduleId">
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delay Minutes</label>
                        <input type="number" name="delay_minutes" min="1" max="1440" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="closeModal('delayModal')">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Report Delay
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openUpdateModal(scheduleId) {
            const form = document.getElementById('updateForm');
            form.action = `/station-master/schedule/${scheduleId}`;
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('updateModal').classList.add('flex');
        }
        
        function openDelayModal(scheduleId) {
            const form = document.getElementById('delayForm');
            document.getElementById('delayScheduleId').value = scheduleId;
            form.action = `/station-master/schedule/${scheduleId}/delay`;
            document.getElementById('delayModal').classList.remove('hidden');
            document.getElementById('delayModal').classList.add('flex');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'updateModal') {
                closeModal('updateModal');
            }
            if (event.target.id === 'delayModal') {
                closeModal('delayModal');
            }
        }
    </script>
</div>
@endsection
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
                <form action="{{ route('station-master.delays.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Train</label>
                            <select name="train_schedule_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select a train...</option>
                                @foreach($activeSchedules as $schedule)
                                <option value="{{ $schedule->id }}">
                                    {{ $schedule->train->train_name ?? 'N/A' }} (#{{ $schedule->train->train_number ?? 'N/A' }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Delay Duration</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="number" name="delay_hours" min="0" max="24" placeholder="Hours" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <input type="number" name="delay_minutes" min="0" max="59" placeholder="Minutes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Delay</label>
                            <select name="reason" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select reason...</option>
                                <option value="technical_issues">Technical Issues</option>
                                <option value="weather_conditions">Weather Conditions</option>
                                <option value="signal_problems">Signal Problems</option>
                                <option value="track_maintenance">Track Maintenance</option>
                                <option value="passenger_issues">Passenger Issues</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                            <textarea name="details" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Provide additional details about the delay..."></textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                                Report Delay
                            </button>
                            <button type="button" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                                Send Notification
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Current Delays -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🚨 Current Delays</h2>
                <div class="space-y-4">
                    @forelse($delays as $delay)
                    <div class="border {{ $delay->delay_minutes > 10 ? 'border-red-200 bg-red-50' : 'border-yellow-200 bg-yellow-50' }} rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $delay->train->train_name ?? 'N/A' }} (#{{ $delay->train->train_number ?? 'N/A' }})</h4>
                                <p class="text-sm text-gray-600">{{ $delay->route->startStation->station_name ?? 'N/A' }} → {{ $delay->route->endStation->station_name ?? 'N/A' }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $delay->delay_minutes > 10 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $delay->delay_minutes }} min delay
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">
                            <strong>Reason:</strong> {{ ucfirst(str_replace('_', ' ', $delay->reason ?? 'Not specified')) }}
                        </p>
                        <div class="flex space-x-2">
                            <button class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded" onclick="openUpdateModal({{ $delay->id }})">Update</button>
                            <form action="{{ route('station-master.delays.resolve', $delay) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Resolve</button>
                            </form>
                            <button class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Notify Passengers</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-3xl mb-2">✅</div>
                        <p>No current delays. All trains are running on time.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update Delay Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Delay</h3>
            </div>
            <form id="updateDelayForm" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delay Duration</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="number" name="delay_hours" min="0" max="24" placeholder="Hours" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <input type="number" name="delay_minutes" min="0" max="59" placeholder="Minutes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Delay</label>
                        <select name="reason" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select reason...</option>
                            <option value="technical_issues">Technical Issues</option>
                            <option value="weather_conditions">Weather Conditions</option>
                            <option value="signal_problems">Signal Problems</option>
                            <option value="track_maintenance">Track Maintenance</option>
                            <option value="passenger_issues">Passenger Issues</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                        <textarea name="details" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Provide additional details about the delay..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="closeModal('updateModal')">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Delay
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openUpdateModal(scheduleId) {
            const form = document.getElementById('updateDelayForm');
            form.action = `/station-master/delays/${scheduleId}`;
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('updateModal').classList.add('flex');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'updateModal') {
                closeModal('updateModal');
            }
        }
    </script>
</div>
@endsection
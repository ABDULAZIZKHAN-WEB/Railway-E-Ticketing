@extends('layouts.railway')

@section('title', 'Platform Management - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🔧 Platform Management</h1>
                    <p class="text-gray-600 mt-2">Manage platform status and operations</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('station-master.platforms.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        + Add New Platform
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Platform Status Overview -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Platform Status</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($platforms as $platform)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $platform->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $platform->description ?? 'No description' }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($platform->status === 'available') bg-green-100 text-green-800
                                    @elseif($platform->status === 'occupied') bg-red-100 text-red-800
                                    @elseif($platform->status === 'maintenance') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($platform->status) }}
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-4">
                                <p>Type: {{ ucfirst($platform->type) }}</p>
                                <p>Capacity: {{ $platform->capacity }} trains</p>
                                @if($platform->current_train)
                                <p>Current Train: {{ $platform->current_train }}</p>
                                @endif
                                @if($platform->next_arrival)
                                <p>Next Arrival: {{ $platform->next_arrival->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                            
                            <div class="flex space-x-2">
                                @if($platform->status === 'available')
                                <form action="{{ route('station-master.platforms.update-status', $platform) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="occupied">
                                    <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-200 transition duration-200">
                                        🚂 Occupy
                                    </button>
                                </form>
                                @elseif($platform->status === 'occupied')
                                <form action="{{ route('station-master.platforms.update-status', $platform) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="available">
                                    <button type="submit" class="w-full bg-green-100 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-200 transition duration-200">
                                        ✅ Clear
                                    </button>
                                </form>
                                @elseif($platform->status === 'maintenance')
                                <a href="{{ route('station-master.platforms.edit', $platform) }}" class="flex-1 bg-blue-100 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-200 transition duration-200 text-center">
                                    📋 Update
                                </a>
                                <form action="{{ route('station-master.platforms.update-status', $platform) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="available">
                                    <button type="submit" class="w-full bg-green-100 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-200 transition duration-200">
                                        ✅ Complete
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('station-master.platforms.update-status', $platform) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="maintenance">
                                    <button type="submit" class="w-full bg-yellow-100 text-yellow-700 py-2 px-3 rounded text-sm hover:bg-yellow-200 transition duration-200">
                                        🔧 Maintenance
                                    </button>
                                </form>
                                <form action="{{ route('station-master.platforms.update-status', $platform) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="blocked">
                                    <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-200 transition duration-200">
                                        🚫 Block
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="text-gray-500">No platforms found.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Platform Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <button class="bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200" onclick="location.reload();">
                            <div class="text-2xl mb-2">🔄</div>
                            <div class="text-sm font-medium">Refresh All</div>
                        </button>
                        <a href="{{ route('station-master.platforms.create') }}" class="bg-yellow-50 text-yellow-700 p-4 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <div class="text-2xl mb-2">🔧</div>
                            <div class="text-sm font-medium">Schedule Maintenance</div>
                        </a>
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
                    
                    <form action="{{ route('station-master.platforms.control-panel') }}" method="POST" id="platform-control-form">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Platform</label>
                                <select name="platform_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="platform-select">
                                    <option value="">Select a platform</option>
                                    @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="action-select">
                                    <option value="">Select an action</option>
                                    <option value="available">Change to Available</option>
                                    <option value="occupied">Change to Occupied</option>
                                    <option value="maintenance">Schedule Maintenance</option>
                                    <option value="blocked">Emergency Block</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add notes about the action..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200" id="execute-button" disabled>
                                Execute Action
                            </button>
                        </div>
                    </form>
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
    
    <script>
        // Enable/disable execute button based on selections
        const platformSelect = document.getElementById('platform-select');
        const actionSelect = document.getElementById('action-select');
        const executeButton = document.getElementById('execute-button');
        
        function updateFormState() {
            if (platformSelect.value && actionSelect.value) {
                executeButton.disabled = false;
            } else {
                executeButton.disabled = true;
            }
        }
        
        platformSelect.addEventListener('change', updateFormState);
        actionSelect.addEventListener('change', updateFormState);
    </script>
</div>
@endsection
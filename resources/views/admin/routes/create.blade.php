@extends('layouts.railway')

@section('title', 'Create Route - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">➕ Create Route</h1>
                    <p class="text-gray-600">Add a new train route</p>
                </div>
                <a href="{{ route('admin.routes.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to Routes
                </a>
            </div>
        </div>

        <!-- Create Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.routes.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Route Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Route Name *</label>
                        <input type="text" name="route_name" value="{{ old('route_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Dhaka to Chittagong via Comilla">
                        @error('route_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Start Station -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Station *</label>
                        <select name="start_station_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select start station</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{ old('start_station_id') == $station->id ? 'selected' : '' }}>
                                    {{ $station->station_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('start_station_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- End Station -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Station *</label>
                        <select name="end_station_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select end station</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{ old('end_station_id') == $station->id ? 'selected' : '' }}>
                                    {{ $station->station_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('end_station_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Total Distance -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Distance (km) *</label>
                        <input type="number" step="0.01" name="total_distance_km" value="{{ old('total_distance_km') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 250.50">
                        @error('total_distance_km')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Estimated Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Duration (minutes) *</label>
                        <input type="number" name="estimated_duration_minutes" value="{{ old('estimated_duration_minutes') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 300">
                        @error('estimated_duration_minutes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Intermediate Stations Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Intermediate Stations</h3>
                    <div id="intermediate-stations-container">
                        <!-- Intermediate stations will be added here dynamically -->
                    </div>
                    <button type="button" id="add-intermediate-station" class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                        ➕ Add Intermediate Station
                    </button>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        🛤️ Create Route
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for dynamic intermediate stations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('intermediate-stations-container');
        const addButton = document.getElementById('add-intermediate-station');
        const stations = @json($stations);
        
        // Create station options
        let stationOptions = '<option value="">Select station</option>';
        stations.forEach(station => {
            stationOptions += `<option value="${station.id}">${station.station_name}</option>`;
        });
        
        addButton.addEventListener('click', function() {
            const index = container.children.length;
            const intermediateStationHtml = `
                <div class="intermediate-station-item bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-800">Intermediate Station #${index + 1}</h4>
                        <button type="button" class="remove-intermediate-station text-red-600 hover:text-red-800">
                            🗑️ Remove
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Station *</label>
                            <select name="intermediate_stations[${index}][station_id]" class="intermediate-station-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                ${stationOptions}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sequence Order *</label>
                            <input type="number" name="intermediate_stations[${index}][sequence_order]" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 1, 2, 3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Distance from Start (km)</label>
                            <input type="number" step="0.01" name="intermediate_stations[${index}][distance_from_start_km]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 50.25">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Arrival Time Offset (minutes)</label>
                            <input type="number" name="intermediate_stations[${index}][arrival_time_offset_minutes]" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 60">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departure Time Offset (minutes)</label>
                            <input type="number" name="intermediate_stations[${index}][departure_time_offset_minutes]" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 65">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Halt Duration (minutes)</label>
                            <input type="number" name="intermediate_stations[${index}][halt_duration_minutes]" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 5">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Platform Number</label>
                            <input type="text" name="intermediate_stations[${index}][platform_number]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 2">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', intermediateStationHtml);
        });
        
        // Handle removal of intermediate stations
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-intermediate-station')) {
                e.target.closest('.intermediate-station-item').remove();
                // Re-index the remaining items
                reindexIntermediateStations();
            }
        });
        
        function reindexIntermediateStations() {
            const items = container.querySelectorAll('.intermediate-station-item');
            items.forEach((item, index) => {
                const title = item.querySelector('h4');
                title.textContent = `Intermediate Station #${index + 1}`;
                
                const inputs = item.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }
    });
</script>
@endsection
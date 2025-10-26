@extends('layouts.railway')

@section('title', 'Edit Train Schedule - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Train Schedule</h1>
                    <p class="text-gray-600">Modify train schedule details</p>
                </div>
                <a href="{{ route('admin.train-schedules.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to Schedules
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.train-schedules.update', $schedule) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Train Selection -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Train *</label>
                        <select name="train_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a train</option>
                            @foreach($trains as $train)
                                <option value="{{ $train->id }}" {{ (old('train_id', $schedule->train_id) == $train->id) ? 'selected' : '' }}>
                                    {{ $train->train_name }} ({{ $train->train_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('train_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Route Selection -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Route *</label>
                        <select name="route_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a route</option>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}" {{ (old('route_id', $schedule->route_id) == $route->id) ? 'selected' : '' }}>
                                    {{ $route->startStation->station_name }} → {{ $route->endStation->station_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-2">
                            <a href="{{ route('admin.routes.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                + Create New Route
                            </a>
                        </div>
                        @error('route_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Departure Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departure Time *</label>
                        <input type="datetime-local" name="departure_time" value="{{ old('departure_time', $schedule->departure_time ? $schedule->departure_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('departure_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Arrival Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Arrival Time *</label>
                        <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', $schedule->arrival_time ? $schedule->arrival_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('arrival_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Running Days -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Running Days *</label>
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                $dayValues = [0, 1, 2, 3, 4, 5, 6];
                            @endphp
                            @for($i = 0; $i < 7; $i++)
                                <div class="flex items-center">
                                    <input type="checkbox" name="running_days[]" value="{{ $dayValues[$i] }}" id="day_{{ $dayValues[$i] }}" 
                                        {{ in_array($dayValues[$i], old('running_days', $schedule->running_days_json ?? [])) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="day_{{ $dayValues[$i] }}" class="ml-2 text-sm text-gray-700">{{ substr($days[$i], 0, 3) }}</label>
                                </div>
                            @endfor
                        </div>
                        @error('running_days')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Effective From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Effective From *</label>
                        <input type="date" name="effective_from" value="{{ old('effective_from', $schedule->effective_from ? $schedule->effective_from->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('effective_from')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Effective To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Effective To</label>
                        <input type="date" name="effective_to" value="{{ old('effective_to', $schedule->effective_to ? $schedule->effective_to->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('effective_to')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        🚄 Update Train Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
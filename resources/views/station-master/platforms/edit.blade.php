@extends('layouts.railway')

@section('title', 'Edit Platform - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Platform</h1>
                    <p class="text-gray-600 mt-2">Update platform details</p>
                </div>
                <a href="{{ route('station-master.platforms') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    ← Back to Platforms
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('station-master.platforms.update', $platform) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Platform Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('name', $platform->name) }}">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Platform Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="passenger" {{ old('type', $platform->type) == 'passenger' ? 'selected' : '' }}>Passenger</option>
                            <option value="freight" {{ old('type', $platform->type) == 'freight' ? 'selected' : '' }}>Freight</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <input type="text" name="description" id="description"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('description', $platform->description) }}">
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Capacity (Coaches) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="capacity" id="capacity" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('capacity', $platform->capacity) }}">
                        @error('capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="available" {{ old('status', $platform->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ old('status', $platform->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ old('status', $platform->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="blocked" {{ old('status', $platform->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Train -->
                    <div>
                        <label for="current_train" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Train
                        </label>
                        <input type="text" name="current_train" id="current_train"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('current_train', $platform->current_train) }}">
                        @error('current_train')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Next Arrival -->
                    <div>
                        <label for="next_arrival" class="block text-sm font-medium text-gray-700 mb-2">
                            Next Arrival
                        </label>
                        <input type="datetime-local" name="next_arrival" id="next_arrival"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('next_arrival', $platform->next_arrival ? $platform->next_arrival->format('Y-m-d\TH:i') : '') }}">
                        @error('next_arrival')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Maintenance -->
                    <div>
                        <label for="last_maintenance" class="block text-sm font-medium text-gray-700 mb-2">
                            Last Maintenance
                        </label>
                        <input type="datetime-local" name="last_maintenance" id="last_maintenance"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('last_maintenance', $platform->last_maintenance ? $platform->last_maintenance->format('Y-m-d\TH:i') : '') }}">
                        @error('last_maintenance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Maintenance Notes -->
                    <div class="md:col-span-2">
                        <label for="maintenance_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Maintenance Notes
                        </label>
                        <textarea name="maintenance_notes" id="maintenance_notes" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('maintenance_notes', $platform->maintenance_notes) }}</textarea>
                        @error('maintenance_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('station-master.platforms') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Update Platform
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
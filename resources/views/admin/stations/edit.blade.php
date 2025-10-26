@extends('layouts.railway')

@section('title', 'Edit Station - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Station</h1>
                    <p class="text-gray-600 mt-2">Update the station details</p>
                </div>
                <a href="{{ route('admin.stations') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    ← Back to Stations
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.stations.update', $station) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Station Code -->
                    <div>
                        <label for="station_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Station Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="station_code" id="station_code" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('station_code', $station->station_code) }}">
                        @error('station_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Station Name -->
                    <div>
                        <label for="station_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Station Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="station_name" id="station_name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('station_name', $station->station_name) }}">
                        @error('station_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Division -->
                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 mb-2">
                            Division <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="division" id="division" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('division', $station->division) }}">
                        @error('division')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            District <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="district" id="district" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('district', $station->district) }}">
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                            Latitude
                        </label>
                        <input type="number" name="latitude" id="latitude" step="any"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('latitude', $station->latitude) }}">
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                            Longitude
                        </label>
                        <input type="number" name="longitude" id="longitude" step="any"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('longitude', $station->longitude) }}">
                        @error('longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Status</option>
                            <option value="active" {{ (old('status', $station->status) == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ (old('status', $station->status) == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bangla Name (Optional) -->
                    <div>
                        <label for="station_name_bn" class="block text-sm font-medium text-gray-700 mb-2">
                            Station Name (Bangla) <span class="text-gray-500">(Optional)</span>
                        </label>
                        <input type="text" name="station_name_bn" id="station_name_bn"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('station_name_bn', $station->station_name_bn) }}">
                        @error('station_name_bn')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Facilities <span class="text-gray-500">(Optional)</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="waiting_room" id="facility_waiting_room"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('waiting_room', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_waiting_room" class="ml-2 text-sm text-gray-700">Waiting Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="restaurant" id="facility_restaurant"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('restaurant', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_restaurant" class="ml-2 text-sm text-gray-700">Restaurant</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="atm" id="facility_atm"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('atm', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_atm" class="ml-2 text-sm text-gray-700">ATM</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="parking" id="facility_parking"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('parking', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_parking" class="ml-2 text-sm text-gray-700">Parking</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="wifi" id="facility_wifi"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('wifi', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_wifi" class="ml-2 text-sm text-gray-700">WiFi</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="facilities[]" value="medical" id="facility_medical"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ in_array('medical', old('facilities', $station->facilities ?? [])) ? 'checked' : '' }}>
                            <label for="facility_medical" class="ml-2 text-sm text-gray-700">Medical</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('admin.stations') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        Update Station
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'Search Trains - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">🚄 Search Trains</h1>
            <p class="text-lg text-gray-600">Find and book your perfect train journey across Bangladesh</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <form action="{{ route('search.trains.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- From Station -->
                    <div>
                        <label for="from_station" class="block text-sm font-medium text-gray-700 mb-2">
                            🚉 From Station
                        </label>
                        <select name="from_station" id="from_station" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select departure station</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->station_code }}" {{ (old('from_station') == $station->station_code || (isset($fromStation) && $fromStation == $station->station_code)) ? 'selected' : '' }}>
                                    {{ $station->station_name }} ({{ $station->station_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('from_station')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- To Station -->
                    <div>
                        <label for="to_station" class="block text-sm font-medium text-gray-700 mb-2">
                            🎯 To Station
                        </label>
                        <select name="to_station" id="to_station" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select destination station</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->station_code }}" {{ (old('to_station') == $station->station_code || (isset($toStation) && $toStation == $station->station_code)) ? 'selected' : '' }}>
                                    {{ $station->station_name }} ({{ $station->station_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('to_station')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Journey Date -->
                    <div>
                        <label for="journey_date" class="block text-sm font-medium text-gray-700 mb-2">
                            📅 Journey Date
                        </label>
                        <input type="date" name="journey_date" id="journey_date" required
                               min="{{ date('Y-m-d') }}" 
                               value="{{ old('journey_date', date('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('journey_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Class Preference (Optional) -->
                    <div>
                        <label for="class_preference" class="block text-sm font-medium text-gray-700 mb-2">
                            🎫 Class Preference (Optional)
                        </label>
                        <select name="class_preference" id="class_preference" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">All Classes</option>
                            <option value="AC_B" {{ old('class_preference') == 'AC_B' ? 'selected' : '' }}>AC Berth</option>
                            <option value="AC_S" {{ old('class_preference') == 'AC_S' ? 'selected' : '' }}>AC Seat</option>
                            <option value="SNIGDHA" {{ old('class_preference') == 'SNIGDHA' ? 'selected' : '' }}>Snigdha</option>
                            <option value="S_CHAIR" {{ old('class_preference') == 'S_CHAIR' ? 'selected' : '' }}>Shovan Chair</option>
                            <option value="SHOVON" {{ old('class_preference') == 'SHOVON' ? 'selected' : '' }}>Shovon</option>
                            <option value="F_BERTH" {{ old('class_preference') == 'F_BERTH' ? 'selected' : '' }}>First Berth</option>
                        </select>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="text-red-400">⚠️</div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Search Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-gradient-to-r from-green-600 to-red-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-green-700 hover:to-red-700 transform hover:scale-105 transition duration-200 shadow-lg">
                        🔍 Search Trains
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Tips -->
        <div class="bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Quick Tips</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Book tickets up to 30 days in advance</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>AC coaches are available on intercity trains</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Check train schedules for accurate timings</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Carry valid ID proof during travel</span>
                </div>
            </div>
        </div>

        <!-- Popular Routes -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">🔥 Popular Routes</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('search.trains') }}?from=DHAKA&to=CTG" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-200 hover:bg-green-50">
                    <div class="font-semibold text-gray-800">Dhaka → Chittagong</div>
                    <div class="text-sm text-gray-600">Most popular intercity route</div>
                </a>
                <a href="{{ route('search.trains') }}?from=DHAKA&to=SYL" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-200 hover:bg-green-50">
                    <div class="font-semibold text-gray-800">Dhaka → Sylhet</div>
                    <div class="text-sm text-gray-600">Scenic northeastern journey</div>
                </a>
                <a href="{{ route('search.trains') }}?from=DHAKA&to=RAJ" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-200 hover:bg-green-50">
                    <div class="font-semibold text-gray-800">Dhaka → Rajshahi</div>
                    <div class="text-sm text-gray-600">Western region connection</div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Check if we have query parameters and set them on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if elements exist before trying to access them
    const fromStationElement = document.getElementById('from_station');
    const toStationElement = document.getElementById('to_station');
    
    if (fromStationElement && toStationElement) {
        const urlParams = new URLSearchParams(window.location.search);
        const fromStation = urlParams.get('from');
        const toStation = urlParams.get('to');
        
        if (fromStation) {
            fromStationElement.value = fromStation;
        }
        
        if (toStation) {
            toStationElement.value = toStation;
        }
        
        // Add event listeners only if elements exist
        fromStationElement.addEventListener('change', function() {
            const toSelect = document.getElementById('to_station');
            const selectedValue = this.value;
            
            if (toSelect) {
                // Enable all options first
                Array.from(toSelect.options).forEach(option => {
                    option.disabled = false;
                });
                
                // Disable the selected from station in to dropdown
                if (selectedValue) {
                    Array.from(toSelect.options).forEach(option => {
                        if (option.value === selectedValue) {
                            option.disabled = true;
                        }
                    });
                    
                    // If to station is same as from, reset it
                    if (toSelect.value === selectedValue) {
                        toSelect.value = '';
                    }
                }
            }
        });
        
        toStationElement.addEventListener('change', function() {
            const fromSelect = document.getElementById('from_station');
            const selectedValue = this.value;
            
            if (fromSelect) {
                // Enable all options first
                Array.from(fromSelect.options).forEach(option => {
                    option.disabled = false;
                });
                
                // Disable the selected to station in from dropdown
                if (selectedValue) {
                    Array.from(fromSelect.options).forEach(option => {
                        if (option.value === selectedValue) {
                            option.disabled = true;
                        }
                    });
                    
                    // If from station is same as to, reset it
                    if (fromSelect.value === selectedValue) {
                        fromSelect.value = '';
                    }
                }
            }
        });
    }
});
</script>
@endsection
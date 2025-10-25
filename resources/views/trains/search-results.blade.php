@extends('layouts.railway')

@section('title', 'Train Search Results - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Search Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">🚄 Available Trains</h1>
                    <div class="flex items-center space-x-4 text-gray-600">
                        <span class="flex items-center">
                            <span class="font-medium">{{ $fromStation->station_name }}</span>
                            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                            <span class="font-medium">{{ $toStation->station_name }}</span>
                        </span>
                        <span class="text-gray-400">|</span>
                        <span>📅 {{ date('d M Y, l', strtotime($request->journey_date)) }}</span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Modify Search
                    </button>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        🔄 Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <span class="font-medium text-gray-700">Filter by:</span>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option>All Classes</option>
                    <option>AC Berth</option>
                    <option>AC Seat</option>
                    <option>Snigdha</option>
                    <option>Shovan Chair</option>
                    <option>Shovon</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option>All Times</option>
                    <option>Morning (6AM - 12PM)</option>
                    <option>Afternoon (12PM - 6PM)</option>
                    <option>Evening (6PM - 12AM)</option>
                    <option>Night (12AM - 6AM)</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option>Sort by Departure</option>
                    <option>Sort by Price</option>
                    <option>Sort by Duration</option>
                </select>
            </div>
        </div>

        <!-- Train Results -->
        <div class="space-y-6">
            @forelse($trains as $train)
            <div class="train-card fade-in">
                <!-- Train Header -->
                <div class="train-card-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $train['train_name'] }}</h3>
                            <p class="text-gray-600">Train #{{ $train['train_number'] }}</p>
                        </div>
                        <div class="mt-2 md:mt-0 flex items-center space-x-6 text-sm">
                            <div class="text-center">
                                <div class="font-bold text-lg text-gray-800">{{ $train['departure_time'] }}</div>
                                <div class="text-gray-600">{{ $fromStation->station_name }}</div>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="text-gray-500 text-xs">{{ $train['duration'] }}</div>
                                <div class="w-16 h-px bg-gray-300 my-1"></div>
                                <div class="text-gray-500 text-xs">Direct</div>
                            </div>
                            <div class="text-center">
                                <div class="font-bold text-lg text-gray-800">{{ $train['arrival_time'] }}</div>
                                <div class="text-gray-600">{{ $toStation->station_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Class Options -->
                <div class="train-card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($train['classes'] as $class)
                        <div class="seat-class-card">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $class['class_name'] }}</h4>
                                    <p class="text-sm text-gray-600">{{ $class['available_seats'] }} seats available</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600">৳{{ number_format($class['fare']) }}</div>
                                    <div class="text-xs text-gray-500">per person</div>
                                </div>
                            </div>

                            @if($class['available_seats'] > 0)
                            <button class="w-full btn-railway text-sm"
                                data-train="{{ $train['train_number'] }}" 
                                data-class="{{ $class['class_code'] }}" 
                                data-fare="{{ $class['fare'] }}"
                                onclick="selectTrain(this.dataset.train, this.dataset.class, this.dataset.fare)">
                                Select Seats
                            </button>
                            @else
                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                Sold Out
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Train Amenities -->
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Confirmed Booking
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45-1.5a1.5 1.5 0 103 0 1.5 1.5 0 00-3 0z" clip-rule="evenodd"></path>
                            </svg>
                            E-Ticket Available
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Refundable
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🚫</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Trains Found</h3>
                <p class="text-gray-600 mb-6">Sorry, no trains are available for the selected route and date.</p>
                <button onclick="window.history.back()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                    Try Different Search
                </button>
            </div>
            @endforelse
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">💡 Booking Tips</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                <div class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Book early for better seat availability and lower prices</span>
                </div>
                <div class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>AC coaches provide better comfort for long journeys</span>
                </div>
                <div class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Check train punctuality and reviews before booking</span>
                </div>
                <div class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Carry valid ID proof during travel for verification</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectTrain(trainNumber, classCode, fare) {
        // Store selection in session storage for booking process
        sessionStorage.setItem('selectedTrain', JSON.stringify({
            train_number: trainNumber,
            class_code: classCode,
            fare: fare,
            from_station: "{{ $request->from_station }}",
            to_station: "{{ $request->to_station }}",
            journey_date: "{{ $request->journey_date }}"
        }));

        // Redirect to seat selection page
        window.location.href = '/booking/seat-selection';
    }
</script>
@endsection
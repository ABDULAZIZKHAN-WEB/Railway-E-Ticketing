@extends('layouts.railway')

@section('title', 'Search Results - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🚂 Train Search Results</h1>
            <p class="text-gray-600">
                {{ $fromStation->station_name }} → {{ $toStation->station_name }} 
                | {{ \Carbon\Carbon::parse($request->journey_date)->format('d M Y') }}
            </p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Class Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Class</label>
                    <select onchange="filterByClass(this.value)" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">All Classes</option>
                        <option value="AC_B">AC Berth</option>
                        <option value="AC_S">AC Seat</option>
                        <option value="SNIGDHA">Snigdha</option>
                        <option value="S_CHAIR">Shovan Chair</option>
                        <option value="SHOVON">Shovon</option>
                        <option value="F_BERTH">First Berth</option>
                    </select>
                </div>

                <!-- Time Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Departure Time</label>
                    <select onchange="filterByTime(this.value)" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Any Time</option>
                        <option value="morning">Morning (6AM - 12PM)</option>
                        <option value="afternoon">Afternoon (12PM - 6PM)</option>
                        <option value="evening">Evening (6PM - 12AM)</option>
                        <option value="night">Night (12AM - 6AM)</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select onchange="sortBy(this.value)" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="departure">Departure Time</option>
                        <option value="price">Price (Low to High)</option>
                        <option value="duration">Duration (Shortest)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Train Results -->
        <div id="trainResults" class="space-y-6">
            @forelse($trains as $train)
            <div class="train-card bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-200"
                 data-class="{{ implode(',', array_column($train['classes'], 'class_code')) }}"
                 data-time="{{ $train['departure_time'] }}"
                 data-price="{{ min(array_column($train['classes'], 'fare')) }}"
                 data-duration="{{ $train['duration'] }}">
                <!-- Train Header -->
                <div class="bg-gradient-to-r from-green-600 to-red-600 p-4 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold">{{ $train['train_name'] }}</h3>
                            <p class="text-green-100">Train #{{ $train['train_number'] }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold">{{ $train['departure_time'] }}</div>
                            <div class="text-green-100">{{ $train['duration'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Route Info -->
                <div class="p-4 border-b">
                    <div class="flex justify-between items-center">
                        <div class="text-center">
                            <div class="font-semibold">{{ $fromStation->station_name }}</div>
                            <div class="text-sm text-gray-600">{{ $train['departure_time'] }}</div>
                        </div>
                        <div class="flex-1 mx-4">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="bg-white px-2 text-gray-500 text-sm">↓</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold">{{ $toStation->station_name }}</div>
                            <div class="text-sm text-gray-600">{{ $train['arrival_time'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Seat Classes -->
                <div class="p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Available Classes</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($train['classes'] as $class)
                        <div class="seat-class-card border rounded-lg p-3 hover:shadow-md transition duration-200">
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
                            <!-- Use form instead of JavaScript -->
                            <form method="POST" action="{{ route('booking.select-train') }}">
                                @csrf
                                <input type="hidden" name="train_number" value="{{ $train['train_number'] }}">
                                <input type="hidden" name="class_code" value="{{ $class['class_code'] }}">
                                <input type="hidden" name="fare" value="{{ $class['fare'] }}">
                                <input type="hidden" name="schedule_id" value="{{ $train['schedule_id'] }}">
                                <input type="hidden" name="from_station" value="{{ $request->from_station }}">
                                <input type="hidden" name="to_station" value="{{ $request->to_station }}">
                                <input type="hidden" name="journey_date" value="{{ $request->journey_date }}">
                                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-green-700 transition duration-200">
                                    Select Seats
                                </button>
                            </form>
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
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Confirmed Booking
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45-1.5a1.5 1.5 0 103 0 1.5 1.5 0 00-3 0z" clip-rule="evenodd"></path>
                            </svg>
                            E-Ticket Available
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
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
                <a href="{{ route('search.trains') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                    Try Different Search
                </a>
            </div>
            @endforelse
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">💡 Booking Tips</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Book early for better seat availability and lower prices</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>AC coaches provide better comfort for long journeys</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Check train punctuality and reviews before booking</span>
                </div>
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Carry valid ID proof during travel for verification</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterByClass(classCode) {
        const trainCards = document.querySelectorAll('.train-card');
        trainCards.forEach(card => {
            if (classCode === '') {
                card.style.display = 'block';
            } else {
                const cardClasses = card.getAttribute('data-class').split(',');
                if (cardClasses.includes(classCode)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
    
    function filterByTime(timePeriod) {
        const trainCards = document.querySelectorAll('.train-card');
        trainCards.forEach(card => {
            if (timePeriod === '') {
                card.style.display = 'block';
                return;
            }
            
            const departureTime = card.getAttribute('data-time');
            const timeParts = departureTime.split(' ');
            const time = timeParts[0]; // e.g., "7:30"
            const period = timeParts[1]; // e.g., "AM"
            
            const [hours, minutes] = time.split(':').map(Number);
            let hour24 = hours;
            
            if (period === 'PM' && hours !== 12) {
                hour24 += 12;
            } else if (period === 'AM' && hours === 12) {
                hour24 = 0;
            }
            
            let show = false;
            switch(timePeriod) {
                case 'morning':
                    show = hour24 >= 6 && hour24 < 12;
                    break;
                case 'afternoon':
                    show = hour24 >= 12 && hour24 < 18;
                    break;
                case 'evening':
                    show = hour24 >= 18 && hour24 < 24;
                    break;
                case 'night':
                    show = hour24 >= 0 && hour24 < 6;
                    break;
            }
            
            card.style.display = show ? 'block' : 'none';
        });
    }
    
    function sortBy(sortBy) {
        const container = document.getElementById('trainResults');
        const trainCards = Array.from(container.querySelectorAll('.train-card'));
        
        trainCards.sort((a, b) => {
            switch(sortBy) {
                case 'price':
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    return priceA - priceB;
                case 'duration':
                    // For simplicity, we'll sort by duration in minutes
                    const durationA = parseDuration(a.getAttribute('data-duration'));
                    const durationB = parseDuration(b.getAttribute('data-duration'));
                    return durationA - durationB;
                case 'departure':
                default:
                    // Sort by departure time
                    const timeA = parseTime(a.getAttribute('data-time'));
                    const timeB = parseTime(b.getAttribute('data-time'));
                    return timeA - timeB;
            }
        });
        
        // Re-append sorted cards
        trainCards.forEach(card => container.appendChild(card));
    }
    
    function parseDuration(duration) {
        // Parse duration like "7h 15m" to minutes
        const hours = parseInt(duration) || 0;
        const minutesMatch = duration.match(/(\d+)m/);
        const minutes = minutesMatch ? parseInt(minutesMatch[1]) : 0;
        return hours * 60 + minutes;
    }
    
    function parseTime(timeString) {
        // Parse time like "7:30 AM" to minutes since midnight
        const parts = timeString.split(' ');
        const time = parts[0];
        const period = parts[1];
        
        const [hours, minutes] = time.split(':').map(Number);
        let hour24 = hours;
        
        if (period === 'PM' && hours !== 12) {
            hour24 += 12;
        } else if (period === 'AM' && hours === 12) {
            hour24 = 0;
        }
        
        return hour24 * 60 + minutes;
    }
</script>
@endsection
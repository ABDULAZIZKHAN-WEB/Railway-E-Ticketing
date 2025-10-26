@extends('layouts.railway')

@section('title', 'Counter Booking - Ticket Seller')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🎫 Counter Booking</h1>
                    <p class="text-gray-600 mt-2">Create new ticket booking for walk-in customers</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('ticket-seller.search') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        🔍 Search Existing
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">New Booking</h2>
                    
                    <!-- Step 1: Journey Details -->
                    @if(!isset($schedule))
                    <form method="POST" action="{{ route('ticket-seller.booking.search') }}">
                        @csrf
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">1. Journey Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Station</label>
                                    <select name="from_station" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                        <option value="">Select Station</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}" {{ (old('from_station') == $station->id) ? 'selected' : '' }}>
                                                {{ $station->station_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">To Station</label>
                                    <select name="to_station" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                        <option value="">Select Station</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}" {{ (old('to_station') == $station->id) ? 'selected' : '' }}>
                                                {{ $station->station_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date</label>
                                    <input type="date" name="journey_date" value="{{ old('journey_date', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                                🔍 Search Trains
                            </button>
                        </div>
                    </form>
                    @endif

                    <!-- Step 2: Train Selection -->
                    @if(isset($schedules) && count($schedules) > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">2. Select Train & Class</h3>
                        <div class="space-y-4">
                            @foreach($schedules as $schedule)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $schedule->train->train_name }} (#{{ $schedule->train->train_number }})</h4>
                                        <p class="text-sm text-gray-600">
                                            Departure: {{ $schedule->departure_time->format('h:i A') }} • 
                                            Arrival: {{ $schedule->arrival_time->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <form method="POST" action="{{ route('ticket-seller.booking.seats') }}">
                                            @csrf
                                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                            <input type="hidden" name="journey_date" value="{{ $request->journey_date }}">
                                            <select name="seat_class_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm mr-2" required>
                                                @foreach($seatClasses as $class)
                                                    <option value="{{ $class->id }}">{{ $class->class_name }} - ৳{{ number_format($class->base_price_per_km * 50) }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200 text-sm">
                                                View Seats
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @elseif(isset($schedules))
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">2. Select Train & Class</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">No trains found for the selected route and date. Please try different options.</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Step 2: Seat Selection -->
                    @if(isset($coaches))
                    <form method="POST" action="{{ route('ticket-seller.booking.book') }}">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <input type="hidden" name="from_station_id" value="{{ $request->from_station ?? $request->input('from_station') }}">
                        <input type="hidden" name="to_station_id" value="{{ $request->to_station ?? $request->input('to_station') }}">
                        <input type="hidden" name="journey_date" value="{{ $request->journey_date ?? $request->input('journey_date') }}">
                        <input type="hidden" name="seat_class_id" value="{{ $seatClass->id }}">
                        
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-800">2. Select Seats</h3>
                                <div class="text-sm text-gray-600">
                                    <span class="inline-block w-3 h-3 bg-green-500 mr-1"></span> Available
                                    <span class="inline-block w-3 h-3 bg-red-500 mr-1 ml-3"></span> Booked
                                    <span class="inline-block w-3 h-3 bg-gray-300 mr-1 ml-3"></span> Unavailable
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-800">{{ $schedule->train->train_name }} (#{{ $schedule->train->train_number }}) - {{ $seatClass->class_name }}</h4>
                                <p class="text-sm text-gray-600">
                                    Departure: {{ $schedule->departure_time->format('h:i A') }} • 
                                    Arrival: {{ $schedule->arrival_time->format('h:i A') }}
                                </p>
                            </div>
                            
                            <div class="space-y-6">
                                @foreach($coaches as $coach)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h5 class="font-medium text-gray-800 mb-3">Coach {{ $coach->coach_number }}</h5>
                                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                                        @foreach($coach->seats as $seat)
                                        @php
                                            $isBooked = in_array($seat->id, $bookedSeatIds);
                                            $isAvailable = $seat->status === 'available';
                                        @endphp
                                        <div class="relative">
                                            <input type="checkbox" 
                                                   name="passenger_seat_id[]" 
                                                   value="{{ $seat->id }}" 
                                                   id="seat_{{ $seat->id }}"
                                                   class="absolute opacity-0"
                                                   {{ $isBooked || !$isAvailable ? 'disabled' : '' }}>
                                            <label for="seat_{{ $seat->id }}" 
                                                   class="block text-center p-2 border rounded cursor-pointer text-sm
                                                   {{ $isBooked ? 'bg-red-500 text-white' : ($isAvailable ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-300 text-gray-500') }}">
                                                {{ $seat->seat_number }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Step 3: Passenger Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">3. Passenger Information</h3>
                            <div id="passenger-forms">
                                <div class="passenger-form space-y-4 mb-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                            <input type="text" name="passenger_name[]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                                            <input type="number" name="passenger_age[]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" min="1" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                            <select name="passenger_gender[]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">ID Type</label>
                                            <select name="passenger_id_type[]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                                <option value="">Select</option>
                                                <option value="nid">National ID</option>
                                                <option value="passport">Passport</option>
                                                <option value="birth_certificate">Birth Certificate</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">ID Number</label>
                                            <input type="text" name="passenger_id_number[]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-passenger" class="mt-4 text-sm bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-200">
                                + Add Another Passenger
                            </button>
                        </div>

                        <!-- Step 4: Payment -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">4. Payment Method</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                    <input type="radio" name="payment_method" value="cash" class="mr-3" required>
                                    <div>
                                        <div class="font-medium">💰 Cash</div>
                                        <div class="text-sm text-gray-600">Counter payment</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                    <input type="radio" name="payment_method" value="card" class="mr-3" required>
                                    <div>
                                        <div class="font-medium">💳 Card</div>
                                        <div class="text-sm text-gray-600">Debit/Credit card</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                    <input type="radio" name="payment_method" value="mobile" class="mr-3" required>
                                    <div>
                                        <div class="font-medium">📱 Mobile Banking</div>
                                        <div class="text-sm text-gray-600">bKash, Nagad, etc.</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition duration-200">
                            💳 Confirm Booking
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Booking Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @if(isset($request) && isset($schedule))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route</span>
                            <span class="font-medium">
                                {{ $stations->firstWhere('id', $request->from_station ?? $request->input('from_station'))->station_name ?? 'N/A' }} → 
                                {{ $stations->firstWhere('id', $request->to_station ?? $request->input('to_station'))->station_name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($request->journey_date ?? $request->input('journey_date'))->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Train</span>
                            <span class="font-medium">{{ $schedule->train->train_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Class</span>
                            <span class="font-medium">{{ $seatClass->class_name ?? 'N/A' }}</span>
                        </div>
                        @elseif(isset($request))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route</span>
                            <span class="font-medium">
                                {{ $stations->firstWhere('id', $request->from_station)->station_name ?? 'N/A' }} → 
                                {{ $stations->firstWhere('id', $request->to_station)->station_name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($request->journey_date)->format('M d, Y') }}</span>
                        </div>
                        @else
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route</span>
                            <span class="font-medium">Dhaka → Chittagong</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span class="font-medium">{{ date('M d, Y') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Passengers</span>
                            <span class="font-medium" id="passenger-count">1</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
                        @if(isset($seatClass))
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Base Fare</span>
                            <span>৳{{ number_format(($seatClass->base_price_per_km * 50), 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">VAT (5%)</span>
                            <span>৳{{ number_format((($seatClass->base_price_per_km * 50) * 0.05), 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Service Charge</span>
                            <span>৳20.00</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-gray-200 pt-2">
                            <span>Total Amount</span>
                            <span class="text-green-600">৳{{ number_format((($seatClass->base_price_per_km * 50) * 1.05 + 20), 2) }}</span>
                        </div>
                        @else
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Base Fare</span>
                            <span>৳950</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">VAT (5%)</span>
                            <span>৳47.50</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Service Charge</span>
                            <span>৳20</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-gray-200 pt-2">
                            <span>Total Amount</span>
                            <span class="text-green-600">৳1,017.50</span>
                        </div>
                        @endif
                    </div>

                    <button class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition duration-200">
                        💳 Process Payment
                    </button>
                    
                    <button class="w-full mt-2 bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-200">
                        💾 Save as Draft
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add passenger form
    document.getElementById('add-passenger').addEventListener('click', function() {
        const passengerForms = document.getElementById('passenger-forms');
        const newForm = passengerForms.firstElementChild.cloneNode(true);
        
        // Clear input values
        newForm.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        
        passengerForms.appendChild(newForm);
        updatePassengerCount();
    });
    
    // Update passenger count
    function updatePassengerCount() {
        const passengerCount = document.querySelectorAll('.passenger-form').length;
        document.getElementById('passenger-count').textContent = passengerCount;
    }
    
    // Update passenger count when forms are added/removed
    const observer = new MutationObserver(updatePassengerCount);
    observer.observe(document.getElementById('passenger-forms'), { childList: true });
});
</script>
@endsection
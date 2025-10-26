@extends('layouts.railway')

@section('title', 'Seat Selection - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Select Your Seats</h1>
                    <p class="text-gray-600 mt-1">Choose your preferred seats for your journey</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Journey Details</div>
                    <div class="font-semibold">{{ $fromStation->station_name ?? 'N/A' }} → {{ $toStation->station_name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-600">{{ $schedule->train->train_name ?? 'N/A' }} | {{ $bookingData['journey_date'] ?? date('d M Y') }}</div>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.payment') }}" method="POST" id="booking-form">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id ?? '' }}">
            <input type="hidden" name="from_station_id" value="{{ $fromStation->id ?? '' }}">
            <input type="hidden" name="to_station_id" value="{{ $toStation->id ?? '' }}">
            <input type="hidden" name="class_code" value="{{ $seatClass->class_code ?? '' }}">
            <input type="hidden" name="journey_date" value="{{ $bookingData['journey_date'] ?? '' }}">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Seat Map -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold">Coach Layout</h2>
                            <select class="border border-gray-300 rounded-md px-3 py-2">
                                <option>{{ $seatClass->class_name ?? 'AC Chair' }} ({{ $seatClass->class_code ?? 'AC_CHAIR' }})</option>
                            </select>
                        </div>

                        <!-- Legend -->
                        <div class="flex items-center space-x-6 mb-6 text-sm">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                                <span>Available</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                                <span>Occupied</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                                <span>Selected</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                                <span>Reserved</span>
                            </div>
                        </div>

                        <!-- Seat Grid -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="text-center text-sm text-gray-600 mb-4">← Front of Train</div>
                            
                            <!-- Seats Layout -->
                            <div class="space-y-2">
                                @if(isset($coaches) && $coaches->count() > 0)
                                    @foreach($coaches as $coach)
                                        <h3 class="text-center font-medium mb-2">Coach {{ $coach->coach_number }}</h3>
                                        @foreach($coach->seats->chunk(4) as $seatRow)
                                        <div class="flex items-center justify-center space-x-2">
                                            @foreach($seatRow as $seat)
                                            @php
                                                $isOccupied = in_array($seat->id, $bookedSeatIds ?? []);
                                                $isReserved = false; // In a real app, this would check reservation status
                                            @endphp
                                            <button type="button" class="w-8 h-8 text-xs font-medium rounded seat-btn
                                                {{ $isOccupied ? 'bg-red-500 text-white cursor-not-allowed' : 
                                                   ($isReserved ? 'bg-yellow-500 text-white cursor-not-allowed' : 
                                                   'bg-green-500 text-white hover:bg-blue-500') }}"
                                                {{ $isOccupied || $isReserved ? 'disabled' : '' }}
                                                data-seat="{{ $seat->seat_number }}"
                                                data-seat-id="{{ $seat->id }}"
                                                data-seat-status="{{ $isOccupied ? 'occupied' : ($isReserved ? 'reserved' : 'available') }}">
                                                {{ $seat->seat_number }}
                                            </button>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    <!-- Default seat layout if no coaches data -->
                                    @for($row = 1; $row <= 15; $row++)
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Left side seats -->
                                        <div class="flex space-x-1">
                                            @for($seat = 1; $seat <= 2; $seat++)
                                                @php
                                                    $seatNumber = $row . chr(64 + $seat);
                                                    $isOccupied = in_array($seatNumber, ['1A', '3B', '7A', '12B']);
                                                    $isReserved = in_array($seatNumber, ['5A', '9B']);
                                                @endphp
                                                <button type="button" class="w-8 h-8 text-xs font-medium rounded seat-btn
                                                    {{ $isOccupied ? 'bg-red-500 text-white cursor-not-allowed' : 
                                                       ($isReserved ? 'bg-yellow-500 text-white cursor-not-allowed' : 
                                                       'bg-green-500 text-white hover:bg-blue-500') }}"
                                                    {{ $isOccupied || $isReserved ? 'disabled' : '' }}
                                                    data-seat="{{ $seatNumber }}"
                                                    data-seat-status="{{ $isOccupied ? 'occupied' : ($isReserved ? 'reserved' : 'available') }}">
                                                    {{ $seatNumber }}
                                                </button>
                                            @endfor
                                        </div>

                                        <!-- Aisle -->
                                        <div class="w-8 text-center text-xs text-gray-400">{{ $row }}</div>

                                        <!-- Right side seats -->
                                        <div class="flex space-x-1">
                                            @for($seat = 3; $seat <= 4; $seat++)
                                                @php
                                                    $seatNumber = $row . chr(64 + $seat);
                                                    $isOccupied = in_array($seatNumber, ['2C', '6D', '11C', '14D']);
                                                    $isReserved = in_array($seatNumber, ['4C', '8D']);
                                                @endphp
                                                <button type="button" class="w-8 h-8 text-xs font-medium rounded seat-btn
                                                    {{ $isOccupied ? 'bg-red-500 text-white cursor-not-allowed' : 
                                                       ($isReserved ? 'bg-yellow-500 text-white cursor-not-allowed' : 
                                                       'bg-green-500 text-white hover:bg-blue-500') }}"
                                                    {{ $isOccupied || $isReserved ? 'disabled' : '' }}
                                                    data-seat="{{ $seatNumber }}"
                                                    data-seat-status="{{ $isOccupied ? 'occupied' : ($isReserved ? 'reserved' : 'available') }}">
                                                    {{ $seatNumber }}
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                    @endfor
                                @endif
                            </div>
                            
                            <div class="text-center text-sm text-gray-600 mt-4">Back of Train →</div>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-lg font-semibold mb-4">Booking Summary</h3>
                        
                        <!-- Journey Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Train:</span>
                                <span class="font-medium">{{ $schedule->train->train_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Route:</span>
                                <span class="font-medium">{{ $fromStation->station_name ?? 'N/A' }} → {{ $toStation->station_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">{{ $bookingData['journey_date'] ?? date('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Departure:</span>
                                <span class="font-medium">{{ $schedule->departure_time ? $schedule->departure_time->format('g:i A') : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Class:</span>
                                <span class="font-medium">{{ $seatClass->class_name ?? 'AC Chair' }}</span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Selected Seats -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-2">Selected Seats</h4>
                            <div id="selected-seats-container" class="text-sm text-gray-600">
                                <div id="selected-seats">No seats selected</div>
                                <input type="hidden" name="selected_seats" id="selected-seats-input">
                            </div>
                        </div>

                        <!-- Passenger Details -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Passenger Name *</label>
                                <input type="text" id="passenger-name" name="passenger_name" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                       placeholder="Enter passenger name" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                                <input type="tel" id="mobile-number" name="mobile_number" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                       placeholder="01XXXXXXXXX" required pattern="01[0-9]{9}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NID Number *</label>
                                <input type="text" id="nid-number" name="nid_number" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                       placeholder="Enter NID number" required>
                            </div>
                        </div>

                        <!-- Fare Breakdown -->
                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Base Fare:</span>
                                <span>৳ <span id="base-fare">{{ number_format($seatClass->base_price_per_km ?? 850, 2) }}</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">VAT (15%):</span>
                                <span>৳ <span id="vat-amount">{{ number_format(($seatClass->base_price_per_km ?? 850) * 0.15, 2) }}</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Charge:</span>
                                <span>৳ 20.00</span>
                            </div>
                            <hr>
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Total:</span>
                                <span id="total-fare">৳ {{ number_format(($seatClass->base_price_per_km ?? 850) * 1.15 + 20, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button type="submit" id="confirm-booking" 
                                    class="w-full bg-green-600 text-white py-3 rounded-md font-medium hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    disabled>
                                Confirm Booking
                            </button>
                            <button type="button" class="w-full border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50" onclick="window.location.href='{{ route('search.trains') }}'">
                                Back to Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedSeats = [];
    const maxSeats = 4;
    const baseFare = {{ $seatClass->base_price_per_km ?? 850 }};
    const vatRate = 0.15;
    const serviceCharge = 20;
    
    // Seat selection logic
    const seatButtons = document.querySelectorAll('.seat-btn');
    seatButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.disabled) return;
            
            const seatNumber = this.dataset.seat;
            const seatId = this.dataset.seatId || null;
            const seatStatus = this.dataset.seatStatus;
            
            // Check if seat is already selected
            const existingIndex = selectedSeats.findIndex(seat => seat.number === seatNumber);
            
            if (existingIndex !== -1) {
                // Deselect seat
                selectedSeats.splice(existingIndex, 1);
                this.classList.remove('bg-blue-500');
                this.classList.add('bg-green-500');
            } else {
                // Select seat (if under limit)
                if (selectedSeats.length < maxSeats) {
                    selectedSeats.push({
                        number: seatNumber,
                        id: seatId,
                        status: seatStatus
                    });
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-blue-500');
                } else {
                    alert(`You can select maximum ${maxSeats} seats`);
                    return;
                }
            }
            
            updateSummary();
        });
    });
    
    function updateSummary() {
        const selectedSeatsContainer = document.getElementById('selected-seats');
        const selectedSeatsInput = document.getElementById('selected-seats-input');
        const confirmButton = document.getElementById('confirm-booking');
        const totalFareElement = document.getElementById('total-fare');
        
        if (selectedSeats.length === 0) {
            selectedSeatsContainer.innerHTML = 'No seats selected';
            selectedSeatsInput.value = '';
            confirmButton.disabled = true;
        } else {
            // Display selected seats
            const seatElements = selectedSeats.map(seat => 
                `<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1 mb-1">${seat.number}</span>`
            ).join('');
            selectedSeatsContainer.innerHTML = seatElements;
            
            // Update hidden input with selected seats data
            selectedSeatsInput.value = JSON.stringify(selectedSeats);
            
            // Enable confirm button
            confirmButton.disabled = false;
            
            // Update total fare
            const total = (baseFare + (baseFare * vatRate) + serviceCharge) * selectedSeats.length;
            totalFareElement.textContent = `৳ ${total.toFixed(2)}`;
        }
    }
    
    // Form validation
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            if (selectedSeats.length === 0) {
                e.preventDefault();
                alert('Please select at least one seat.');
                return;
            }
            
            // Validate passenger details
            const passengerName = document.getElementById('passenger-name');
            const mobileNumber = document.getElementById('mobile-number');
            const nidNumber = document.getElementById('nid-number');
            
            if (!passengerName || !mobileNumber || !nidNumber) {
                e.preventDefault();
                alert('Please fill in all passenger details before confirming booking.');
                return;
            }
            
            if (!passengerName.value.trim() || !mobileNumber.value.trim() || !nidNumber.value.trim()) {
                e.preventDefault();
                alert('Please fill in all passenger details before confirming booking.');
                return;
            }
            
            // Add selected seats as hidden inputs
            selectedSeats.forEach((seat, index) => {
                const seatInput = document.createElement('input');
                seatInput.type = 'hidden';
                seatInput.name = `selected_seats[${index}][number]`;
                seatInput.value = seat.number;
                bookingForm.appendChild(seatInput);
                
                if (seat.id) {
                    const seatIdInput = document.createElement('input');
                    seatIdInput.type = 'hidden';
                    seatIdInput.name = `selected_seats[${index}][id]`;
                    seatIdInput.value = seat.id;
                    bookingForm.appendChild(seatIdInput);
                }
            });
        });
    }
});
</script>
@endsection
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
                    <div class="font-semibold">Dhaka → Chittagong</div>
                    <div class="text-sm text-gray-600">Suborno Express | 25 Oct 2025</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Seat Map -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Coach Layout</h2>
                        <select class="border border-gray-300 rounded-md px-3 py-2">
                            <option>AC Chair (Ka)</option>
                            <option>Shovan Chair (Gha)</option>
                            <option>Snigdha (Cha)</option>
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
                                        <button class="w-8 h-8 text-xs font-medium rounded seat-btn
                                            {{ $isOccupied ? 'bg-red-500 text-white cursor-not-allowed' : 
                                               ($isReserved ? 'bg-yellow-500 text-white cursor-not-allowed' : 
                                               'bg-green-500 text-white hover:bg-blue-500') }}"
                                            {{ $isOccupied || $isReserved ? 'disabled' : '' }}
                                            data-seat="{{ $seatNumber }}">
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
                                        <button class="w-8 h-8 text-xs font-medium rounded seat-btn
                                            {{ $isOccupied ? 'bg-red-500 text-white cursor-not-allowed' : 
                                               ($isReserved ? 'bg-yellow-500 text-white cursor-not-allowed' : 
                                               'bg-green-500 text-white hover:bg-blue-500') }}"
                                            {{ $isOccupied || $isReserved ? 'disabled' : '' }}
                                            data-seat="{{ $seatNumber }}">
                                            {{ $seatNumber }}
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            @endfor
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
                            <span class="font-medium">Suborno Express</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route:</span>
                            <span class="font-medium">Dhaka → Chittagong</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">25 Oct 2025</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Departure:</span>
                            <span class="font-medium">08:30 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Class:</span>
                            <span class="font-medium">AC Chair</span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Selected Seats -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Selected Seats</h4>
                        <div id="selected-seats" class="text-sm text-gray-600">
                            No seats selected
                        </div>
                    </div>

                    <!-- Passenger Details -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Passenger Name *</label>
                            <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   placeholder="Enter passenger name" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                            <input type="tel" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   placeholder="01XXXXXXXXX" required pattern="01[0-9]{9}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NID Number *</label>
                            <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   placeholder="Enter NID number" required>
                        </div>
                    </div>

                    <!-- Fare Breakdown -->
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Base Fare:</span>
                            <span>৳ 850</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">VAT (15%):</span>
                            <span>৳ 128</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service Charge:</span>
                            <span>৳ 20</span>
                        </div>
                        <hr>
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total:</span>
                            <span id="total-fare">৳ 998</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button id="confirm-booking" 
                                class="w-full bg-green-600 text-white py-3 rounded-md font-medium hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                disabled>
                            Confirm Booking
                        </button>
                        <button class="w-full border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50">
                            Back to Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedSeats = [];
    const maxSeats = 4;
    
    // Seat selection logic
    document.querySelectorAll('.seat-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.disabled) return;
            
            const seatNumber = this.dataset.seat;
            
            if (selectedSeats.includes(seatNumber)) {
                // Deselect seat
                selectedSeats = selectedSeats.filter(seat => seat !== seatNumber);
                this.classList.remove('bg-blue-500');
                this.classList.add('bg-green-500');
            } else {
                // Select seat (if under limit)
                if (selectedSeats.length < maxSeats) {
                    selectedSeats.push(seatNumber);
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-blue-500');
                } else {
                    alert(`You can select maximum ${maxSeats} seats`);
                }
            }
            
            updateSummary();
        });
    });
    
    function updateSummary() {
        const selectedSeatsDiv = document.getElementById('selected-seats');
        const confirmButton = document.getElementById('confirm-booking');
        const totalFare = document.getElementById('total-fare');
        
        if (selectedSeats.length === 0) {
            selectedSeatsDiv.textContent = 'No seats selected';
            confirmButton.disabled = true;
        } else {
            selectedSeatsDiv.innerHTML = selectedSeats.map(seat => 
                `<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1 mb-1">${seat}</span>`
            ).join('');
            confirmButton.disabled = false;
            
            // Update total fare based on number of seats
            const baseFare = 850;
            const vat = Math.round(baseFare * 0.15);
            const serviceCharge = 20;
            const total = (baseFare + vat + serviceCharge) * selectedSeats.length;
            totalFare.textContent = `৳ ${total.toLocaleString()}`;
        }
    }
    
    // Confirm booking
    document.getElementById('confirm-booking').addEventListener('click', function() {
        if (selectedSeats.length === 0) return;
        
        // Validate passenger details
        const passengerName = document.querySelector('input[placeholder="Enter passenger name"]').value;
        const mobileNumber = document.querySelector('input[placeholder="01XXXXXXXXX"]').value;
        const nidNumber = document.querySelector('input[placeholder="Enter NID number"]').value;
        
        if (!passengerName || !mobileNumber || !nidNumber) {
            alert('Please fill in all passenger details before confirming booking.');
            return;
        }
        
        // Store booking data in sessionStorage for payment page
        const bookingData = {
            seats: selectedSeats,
            passengerName: passengerName,
            mobileNumber: mobileNumber,
            nidNumber: nidNumber,
            totalFare: document.getElementById('total-fare').textContent
        };
        
        sessionStorage.setItem('bookingData', JSON.stringify(bookingData));
        
        // Redirect to payment page
        window.location.href = '/booking/payment';
    });
});
</script>
@endsection
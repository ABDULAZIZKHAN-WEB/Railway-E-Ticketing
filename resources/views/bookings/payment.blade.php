@extends('layouts.railway')

@section('title', 'Payment - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">💳 Payment</h1>
                    <p class="text-gray-600 mt-1">Complete your booking payment</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Booking Reference</div>
                    <div class="font-semibold text-lg">#BR{{ rand(100000, 999999) }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-6">Select Payment Method</h2>

                    <!-- Payment Methods -->
                    <div class="space-y-4 mb-6">
                        <!-- Mobile Banking -->
                        <div class="border rounded-lg p-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="mobile_banking" class="mr-3" checked>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">📱 Mobile Banking</div>
                                    <div class="text-sm text-gray-600">bKash, Nagad, Rocket</div>
                                </div>
                                <div class="flex space-x-2">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCA0MCAyNCIgZmlsbD0ibm9uZSI+PHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjI0IiByeD0iNCIgZmlsbD0iI0UyMTM2QyIvPjx0ZXh0IHg9IjIwIiB5PSIxNSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+Ykthc2g8L3RleHQ+PC9zdmc+" alt="bKash" class="h-6">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCA0MCAyNCIgZmlsbD0ibm9uZSI+PHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjI0IiByeD0iNCIgZmlsbD0iI0VDNzA2MyIvPjx0ZXh0IHg9IjIwIiB5PSIxNSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TmFnYWQ8L3RleHQ+PC9zdmc+" alt="Nagad" class="h-6">
                                </div>
                            </label>
                        </div>

                        <!-- Credit/Debit Card -->
                        <div class="border rounded-lg p-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="mr-3">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">💳 Credit/Debit Card</div>
                                    <div class="text-sm text-gray-600">Visa, Mastercard, American Express</div>
                                </div>
                                <div class="flex space-x-2">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCA0MCAyNCIgZmlsbD0ibm9uZSI+PHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjI0IiByeD0iNCIgZmlsbD0iIzAwNTFBNSIvPjx0ZXh0IHg9IjIwIiB5PSIxNSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+VklTQTwvdGV4dD48L3N2Zz4=" alt="Visa" class="h-6">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCA0MCAyNCIgZmlsbD0ibm9uZSI+PHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjI0IiByeD0iNCIgZmlsbD0iI0VCMDAxQiIvPjx0ZXh0IHg9IjIwIiB5PSIxNSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TWFzdGVyPC90ZXh0Pjwvc3ZnPg==" alt="Mastercard" class="h-6">
                                </div>
                            </label>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="border rounded-lg p-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-3">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">🏦 Bank Transfer</div>
                                    <div class="text-sm text-gray-600">Direct bank transfer</div>
                                </div>
                            </label>
                        </div>

                        <!-- Cash on Counter -->
                        <div class="border rounded-lg p-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="cash_counter" class="mr-3">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">💵 Cash at Counter</div>
                                    <div class="text-sm text-gray-600">Pay at railway station counter</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Details Form -->
                    <div id="payment-details">
                        <!-- Mobile Banking Form -->
                        <div id="mobile-banking-form" class="payment-form">
                            <h3 class="font-semibold mb-4">Mobile Banking Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Provider</label>
                                    <select class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option>bKash</option>
                                        <option>Nagad</option>
                                        <option>Rocket</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                                    <input type="tel" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                        placeholder="01XXXXXXXXX">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
                                    <input type="password" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                        placeholder="Enter your PIN">
                                </div>
                            </div>
                        </div>

                        <!-- Card Form -->
                        <div id="card-form" class="payment-form hidden">
                            <h3 class="font-semibold mb-4">Card Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                        placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                            placeholder="MM/YY">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                            placeholder="123">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                        placeholder="Name on card">
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Form -->
                        <div id="bank-transfer-form" class="payment-form hidden">
                            <h3 class="font-semibold mb-4">Bank Transfer Instructions</h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm text-blue-800 mb-2">Transfer the amount to:</p>
                                <div class="space-y-1 text-sm">
                                    <div><strong>Bank:</strong> Bangladesh Railway Bank</div>
                                    <div><strong>Account Name:</strong> Bangladesh Railway E-Ticket</div>
                                    <div><strong>Account Number:</strong> 1234567890123</div>
                                    <div><strong>Routing Number:</strong> 123456789</div>
                                </div>
                                <p class="text-xs text-blue-600 mt-2">
                                    Please use booking reference as transfer reference and upload receipt.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Receipt</label>
                                <input type="file" class="w-full border border-gray-300 rounded-md px-3 py-2"
                                    accept="image/*,.pdf">
                            </div>
                        </div>

                        <!-- Cash Counter Form -->
                        <div id="cash-counter-form" class="payment-form hidden">
                            <h3 class="font-semibold mb-4">Cash Payment Instructions</h3>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm text-yellow-800 mb-2">
                                    Your booking will be reserved for 2 hours. Please visit any railway station counter to complete payment.
                                </p>
                                <div class="space-y-1 text-sm">
                                    <div><strong>Booking Reference:</strong> #BR{{ rand(100000, 999999) }}</div>
                                    <div><strong>Payment Deadline:</strong> {{ date('d M Y, h:i A', strtotime('+2 hours')) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-semibold mb-4">Payment Summary</h3>

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
                            <span class="text-gray-600">Time:</span>
                            <span class="font-medium">{{ $schedule->departure_time ? $schedule->departure_time->format('g:i A') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Class:</span>
                            <span class="font-medium">{{ $seatClass->name ?? 'AC Chair' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Seats:</span>
                            <span class="font-medium" id="selected-seats-display">
                                @if(isset($bookingData['seats']) && is_array($bookingData['seats']))
                                    {{ implode(', ', array_column($bookingData['seats'], 'number')) }}
                                @else
                                    2A, 2B
                                @endif
                            </span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Passenger Details -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Passenger Details</h4>
                        <div class="text-sm space-y-1">
                            <div><strong>Name:</strong> <span id="passenger-name-display">{{ $bookingData['passengerName'] ?? 'John Doe' }}</span></div>
                            <div><strong>Mobile:</strong> <span id="mobile-number-display">{{ $bookingData['mobileNumber'] ?? '01712345678' }}</span></div>
                            <div><strong>NID:</strong> <span id="nid-number-display">{{ $bookingData['nidNumber'] ?? '1234567890123' }}</span></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Fare Breakdown -->
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Base Fare ({{ isset($bookingData['seats']) ? count($bookingData['seats']) : 2 }} seats):</span>
                            <span>৳ {{ number_format(($seatClass->base_price_per_km ?? 850) * (isset($bookingData['seats']) ? count($bookingData['seats']) : 2), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">VAT (15%):</span>
                            <span>৳ {{ number_format((($seatClass->base_price_per_km ?? 850) * (isset($bookingData['seats']) ? count($bookingData['seats']) : 2)) * 0.15, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service Charge:</span>
                            <span>৳ 40</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span>৳ 25</span>
                        </div>
                        <hr>
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total Amount:</span>
                            <span class="text-green-600" id="total-amount-display">
                                ৳ {{ number_format((($seatClass->base_price_per_km ?? 850) * 1.15 + 65) * (isset($bookingData['seats']) ? count($bookingData['seats']) : 2), 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Security Info -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                        <div class="flex items-center text-green-800 text-sm">
                            <span class="mr-2">🔒</span>
                            <span>Your payment is secured with 256-bit SSL encryption</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button id="pay-now-btn"
                            class="w-full bg-green-600 text-white py-3 rounded-md font-medium hover:bg-green-700 transition duration-200">
                            💳 Pay Now - <span id="pay-button-amount">
                                ৳ {{ number_format((($seatClass->base_price_per_km ?? 850) * 1.15 + 65) * (isset($bookingData['seats']) ? count($bookingData['seats']) : 2), 2) }}
                            </span>
                        </button>
                        <button onclick="window.location.href='{{ route('booking.seat-selection') }}'"
                            class="w-full border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50">
                            ← Back to Seat Selection
                        </button>
                    </div>

                    <!-- Payment Timer -->
                    <div class="mt-4 text-center">
                        <div class="text-sm text-gray-600">Session expires in:</div>
                        <div id="payment-timer" class="text-lg font-semibold text-red-600">14:59</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method switching - add null checks
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const paymentForms = document.querySelectorAll('.payment-form');

        if (paymentMethods.length > 0 && paymentForms.length > 0) {
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // Hide all forms
                    paymentForms.forEach(form => form.classList.add('hidden'));

                    // Show selected form
                    const selectedForm = document.getElementById(this.value.replace('_', '-') + '-form');
                    if (selectedForm) {
                        selectedForm.classList.remove('hidden');
                    }
                });
            });
        }

        // Payment timer - add null check
        const timerElement = document.getElementById('payment-timer');
        if (timerElement) {
            let timeLeft = 15 * 60; // 15 minutes

            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    alert('Payment session expired. Please start booking again.');
                    window.location.href = '{{ route('search.trains') }}';
                } else {
                    timeLeft--;
                }
            }

            setInterval(updateTimer, 1000);
        }

        // Pay now button - add null check
        const payNowButton = document.getElementById('pay-now-btn');
        if (payNowButton) {
            payNowButton.addEventListener('click', function() {
                const selectedMethodElement = document.querySelector('input[name="payment_method"]:checked');
                if (!selectedMethodElement) return;
                
                const selectedMethod = selectedMethodElement.value;

                // Simulate payment processing
                this.disabled = true;
                this.innerHTML = '⏳ Processing Payment...';

                setTimeout(() => {
                    alert('Payment successful! Your ticket has been booked.');
                    // Redirect to booking confirmation or my bookings
                    window.location.href = '{{ route('my.bookings') }}';
                }, 3000);
            });
        }
    });
</script>
@endsection
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
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        🔍 Search Existing
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">New Booking</h2>
                    
                    <!-- Step 1: Journey Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">1. Journey Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Station</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <option>Dhaka</option>
                                    <option>Chittagong</option>
                                    <option>Sylhet</option>
                                    <option>Rajshahi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Station</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <option>Chittagong</option>
                                    <option>Dhaka</option>
                                    <option>Sylhet</option>
                                    <option>Rajshahi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                        </div>
                        <button class="mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                            Search Trains
                        </button>
                    </div>

                    <!-- Step 2: Train Selection -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">2. Select Train & Class</h3>
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-500 cursor-pointer">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Suborno Express (#701)</h4>
                                        <p class="text-sm text-gray-600">Departure: 07:30 AM • Arrival: 02:45 PM</p>
                                    </div>
                                    <div class="text-right">
                                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                            <option>AC Seat - ৳950</option>
                                            <option>Snigdha - ৳750</option>
                                            <option>Shovon - ৳450</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Passenger Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">3. Passenger Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                                    <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Type</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option>National ID</option>
                                        <option>Passport</option>
                                        <option>Birth Certificate</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Number</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 text-sm bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-200">
                            + Add Another Passenger
                        </button>
                    </div>

                    <!-- Step 4: Payment -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4">4. Payment Method</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="payment" value="cash" class="mr-3">
                                <div>
                                    <div class="font-medium">💰 Cash</div>
                                    <div class="text-sm text-gray-600">Counter payment</div>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="payment" value="card" class="mr-3">
                                <div>
                                    <div class="font-medium">💳 Card</div>
                                    <div class="text-sm text-gray-600">Debit/Credit card</div>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="payment" value="mobile" class="mr-3">
                                <div>
                                    <div class="font-medium">📱 Mobile Banking</div>
                                    <div class="text-sm text-gray-600">bKash, Nagad, etc.</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Booking Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route</span>
                            <span class="font-medium">Dhaka → Chittagong</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span class="font-medium">{{ date('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Train</span>
                            <span class="font-medium">Suborno Express</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Class</span>
                            <span class="font-medium">AC Seat</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Passengers</span>
                            <span class="font-medium">1</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
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
@endsection
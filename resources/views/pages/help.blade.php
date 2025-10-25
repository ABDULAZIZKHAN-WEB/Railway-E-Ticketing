@extends('layouts.railway')

@section('title', 'Help Center - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">🆘 Help Center</h1>
            <p class="text-xl text-gray-600">Find answers to common questions and get help with your railway bookings</p>
        </div>

        <!-- Search Help -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="max-w-md mx-auto">
                <input type="text" placeholder="Search for help..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <!-- Help Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-200">
                <div class="text-4xl mb-4">🎫</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Booking Help</h3>
                <p class="text-gray-600 mb-4">Learn how to search, book, and manage your train tickets</p>
                <a href="#booking" class="text-green-600 hover:text-green-800 font-medium">Learn More →</a>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-200">
                <div class="text-4xl mb-4">💳</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Payment & Refunds</h3>
                <p class="text-gray-600 mb-4">Information about payments, refunds, and billing</p>
                <a href="#payment" class="text-green-600 hover:text-green-800 font-medium">Learn More →</a>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-200">
                <div class="text-4xl mb-4">🚄</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Travel Information</h3>
                <p class="text-gray-600 mb-4">Train schedules, routes, and travel guidelines</p>
                <a href="#travel" class="text-green-600 hover:text-green-800 font-medium">Learn More →</a>
            </div>
        </div>

        <!-- Quick Help -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">🚀 Quick Help</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Getting Started</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• How to create an account</li>
                        <li>• How to search for trains</li>
                        <li>• How to book tickets</li>
                        <li>• How to make payments</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Common Issues</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Payment failed or pending</li>
                        <li>• Booking confirmation not received</li>
                        <li>• Unable to download ticket</li>
                        <li>• Need to cancel or modify booking</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
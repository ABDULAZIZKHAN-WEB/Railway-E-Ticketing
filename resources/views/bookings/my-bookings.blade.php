@extends('layouts.railway')

@section('title', 'My Bookings - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">🎫 My Bookings</h1>
            <p class="text-gray-600">View and manage all your train ticket bookings</p>
        </div>

        <!-- No Bookings State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-6xl mb-6">🎫</div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">No Bookings Yet</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                You haven't made any train bookings yet. Start by searching for trains and booking your first journey!
            </p>
            <a href="/search-trains" class="bg-gradient-to-r from-green-600 to-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-green-700 hover:to-red-700 transition duration-200">
                🔍 Search Trains
            </a>
        </div>
    </div>
</div>
@endsection
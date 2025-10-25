@extends('layouts.railway')

@section('title', 'Manage Stations - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🏢 Manage Stations</h1>
                    <p class="text-gray-600 mt-2">Add, edit, and manage railway stations</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        + Add New Station
                    </button>
                </div>
            </div>
        </div>

        <!-- Stations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Dhaka Railway Station</h3>
                        <p class="text-sm text-gray-600">Code: DHAKA</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Division:</strong> Dhaka</p>
                    <p><strong>District:</strong> Dhaka</p>
                    <p><strong>Facilities:</strong> Waiting Room, Restaurant, ATM, Parking</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-900 text-sm">Edit</button>
                    <button class="text-green-600 hover:text-green-900 text-sm">View Map</button>
                    <button class="text-red-600 hover:text-red-900 text-sm">Deactivate</button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Chittagong Railway Station</h3>
                        <p class="text-sm text-gray-600">Code: CTG</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Division:</strong> Chittagong</p>
                    <p><strong>District:</strong> Chittagong</p>
                    <p><strong>Facilities:</strong> Waiting Room, Restaurant, ATM</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-900 text-sm">Edit</button>
                    <button class="text-green-600 hover:text-green-900 text-sm">View Map</button>
                    <button class="text-red-600 hover:text-red-900 text-sm">Deactivate</button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Sylhet Railway Station</h3>
                        <p class="text-sm text-gray-600">Code: SYL</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Division:</strong> Sylhet</p>
                    <p><strong>District:</strong> Sylhet</p>
                    <p><strong>Facilities:</strong> Waiting Room, Restaurant</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-900 text-sm">Edit</button>
                    <button class="text-green-600 hover:text-green-900 text-sm">View Map</button>
                    <button class="text-red-600 hover:text-red-900 text-sm">Deactivate</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
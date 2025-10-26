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
                    <a href="{{ route('admin.stations.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        + Add New Station
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.stations') }}">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Search stations..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg" 
                               value="{{ request('search') }}">
                    </div>
                    <div class="flex space-x-2">
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            Filter
                        </button>
                        @if(request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.stations') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                            Clear
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Stations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($stations as $station)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $station->station_name }}</h3>
                        <p class="text-sm text-gray-600">Code: {{ $station->station_code }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($station->status == 'active') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($station->status) }}
                    </span>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Division:</strong> {{ $station->division }}</p>
                    <p><strong>District:</strong> {{ $station->district }}</p>
                    <p><strong>Facilities:</strong> 
                        @if(!empty($station->facilities) && is_array($station->facilities))
                            {{ implode(', ', $station->facilities) }}
                        @else
                            None
                        @endif
                    </p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('admin.stations.edit', $station) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                    <a href="#" class="text-green-600 hover:text-green-900 text-sm">View Map</a>
                    <form action="{{ route('admin.stations.destroy', $station) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this station?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                            @if($station->status == 'active') Deactivate @else Activate @endif
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-3 bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🏢</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Stations Found</h3>
                <p class="text-gray-600 mb-6">No stations match your search criteria.</p>
                <a href="{{ route('admin.stations.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                    + Add New Station
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
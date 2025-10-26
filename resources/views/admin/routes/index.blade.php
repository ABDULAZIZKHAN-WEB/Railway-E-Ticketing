@extends('layouts.railway')

@section('title', 'Routes - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">🛤️ Routes</h1>
                    <p class="text-gray-600">Manage all train routes</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.routes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        ➕ Add New Route
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('admin.routes.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Route name or station" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg mr-2 transition duration-200">
                        🔍 Search
                    </button>
                    <a href="{{ route('admin.routes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                        🔄 Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Routes Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intermediate Stations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($routes as $route)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $route->route_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $route->startStation->station_name }}</div>
                                <div class="text-sm text-gray-500">to {{ $route->endStation->station_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $intermediateCount = $route->routeStations->count();
                                @endphp
                                @if($intermediateCount > 0)
                                    <div class="text-sm text-gray-900">{{ $intermediateCount }} intermediate station(s)</div>
                                    <div class="text-sm text-gray-500">
                                        @foreach($route->routeStations->sortBy('sequence_order')->take(3) as $routeStation)
                                            {{ $routeStation->station->station_name }}@if(!$loop->last), @endif
                                        @endforeach
                                        @if($intermediateCount > 3)
                                            ... and {{ $intermediateCount - 3 }} more
                                        @endif
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">No intermediate stations</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($route->total_distance_km, 2) }} km
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ floor($route->estimated_duration_minutes / 60) }}h {{ $route->estimated_duration_minutes % 60 }}m
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($route->status === 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.routes.edit', $route) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this route?')">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No routes found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($routes->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $routes->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'Platform Details - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Platform Details</h1>
                    <p class="text-gray-600 mt-2">Detailed information for {{ $platform->name }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('station-master.platforms.edit', $platform) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('station-master.platforms') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Platforms
                    </a>
                </div>
            </div>
        </div>

        <!-- Platform Details -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Platform Information</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium">{{ $platform->name }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Description:</span>
                            <span class="font-medium">{{ $platform->description ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium capitalize">{{ $platform->type }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Capacity:</span>
                            <span class="font-medium">{{ $platform->capacity }} coaches</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($platform->status === 'available') bg-green-100 text-green-800
                                    @elseif($platform->status === 'occupied') bg-red-100 text-red-800
                                    @elseif($platform->status === 'maintenance') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($platform->status) }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Operational Details</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Current Train:</span>
                            <span class="font-medium">{{ $platform->current_train ?? 'None' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Next Arrival:</span>
                            <span class="font-medium">{{ $platform->next_arrival ? $platform->next_arrival->format('M d, Y g:i A') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Last Maintenance:</span>
                            <span class="font-medium">{{ $platform->last_maintenance ? $platform->last_maintenance->format('M d, Y g:i A') : 'Never' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $platform->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium">{{ $platform->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($platform->maintenance_notes)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Maintenance Notes</h2>
                <p class="text-gray-700">{{ $platform->maintenance_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Platform Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <button class="bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200">
                    <div class="text-2xl mb-2">🔄</div>
                    <div class="text-sm font-medium">Refresh Status</div>
                </button>
                <button class="bg-yellow-50 text-yellow-700 p-4 rounded-lg hover:bg-yellow-100 transition duration-200">
                    <div class="text-2xl mb-2">🔧</div>
                    <div class="text-sm font-medium">Maintenance</div>
                </button>
                <button class="bg-red-50 text-red-700 p-4 rounded-lg hover:bg-red-100 transition duration-200">
                    <div class="text-2xl mb-2">🚫</div>
                    <div class="text-sm font-medium">Block Platform</div>
                </button>
                <form action="{{ route('station-master.platforms.destroy', $platform) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this platform? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-50 text-red-700 p-4 rounded-lg hover:bg-red-100 transition duration-200">
                        <div class="text-2xl mb-2">🗑️</div>
                        <div class="text-sm font-medium">Delete</div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
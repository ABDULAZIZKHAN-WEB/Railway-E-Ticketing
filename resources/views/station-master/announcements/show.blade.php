@extends('layouts.railway')

@section('title', 'Announcement Details - Station Master')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Announcement Details</h1>
                    <p class="text-gray-600 mt-2">Detailed information for announcement #{{ $announcement->id }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('station-master.announcements.edit', $announcement) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('station-master.announcements') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Announcements
                    </a>
                </div>
            </div>
        </div>

        <!-- Announcement Details -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Announcement Information</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $announcement->type }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Train Number:</span>
                            <span class="font-medium">{{ $announcement->train_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Platform:</span>
                            <span class="font-medium">{{ $announcement->platform ?? 'All Platforms' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Priority:</span>
                            <span class="font-medium capitalize">{{ $announcement->priority }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($announcement->status === 'completed') bg-green-100 text-green-800
                                    @elseif($announcement->status === 'published') bg-blue-100 text-blue-800
                                    @elseif($announcement->status === 'draft') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Schedule Information</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Repeat Times:</span>
                            <span class="font-medium">{{ $announcement->repeat_times }} time(s)</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Repeat Interval:</span>
                            <span class="font-medium">
                                @if($announcement->repeat_interval == 0)
                                    No Interval
                                @elseif($announcement->repeat_interval < 60)
                                    {{ $announcement->repeat_interval }} seconds
                                @else
                                    {{ $announcement->repeat_interval / 60 }} minute(s)
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $announcement->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium">{{ $announcement->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Scheduled At:</span>
                            <span class="font-medium">{{ $announcement->scheduled_at ? $announcement->scheduled_at->format('M d, Y g:i A') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Announcement Messages</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">English Message:</h3>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $announcement->message_en }}</p>
                    </div>
                    @if($announcement->message_bn)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Bengali Message:</h3>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $announcement->message_bn }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Announcement Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <form action="{{ route('station-master.announcements.publish', $announcement) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-blue-50 text-blue-700 p-4 rounded-lg hover:bg-blue-100 transition duration-200">
                        <div class="text-2xl mb-2">📢</div>
                        <div class="text-sm font-medium">Publish</div>
                    </button>
                </form>
                <form action="{{ route('station-master.announcements.complete', $announcement) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-green-50 text-green-700 p-4 rounded-lg hover:bg-green-100 transition duration-200">
                        <div class="text-2xl mb-2">✅</div>
                        <div class="text-sm font-medium">Mark Complete</div>
                    </button>
                </form>
                <form action="{{ route('station-master.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
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
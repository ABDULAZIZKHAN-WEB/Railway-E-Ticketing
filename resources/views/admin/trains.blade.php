@extends('layouts.railway')

@section('title', 'Manage Trains - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🚄 Manage Trains</h1>
                    <p class="text-gray-600 mt-2">Add, edit, and manage railway trains</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('admin.trains.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        + Add New Train
                    </a>
                </div>
            </div>
        </div>

        <!-- Trains List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <form method="GET" action="{{ route('admin.trains') }}">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">All Trains</h2>
                        <div class="flex space-x-4">
                            <input type="text" name="search" placeholder="Search trains..." 
                                   class="px-4 py-2 border border-gray-300 rounded-lg" 
                                   value="{{ request('search') }}">
                            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">All Types</option>
                                <option value="express" {{ request('type') == 'express' ? 'selected' : '' }}>Express</option>
                                <option value="mail" {{ request('type') == 'mail' ? 'selected' : '' }}>Mail</option>
                                <option value="local" {{ request('type') == 'local' ? 'selected' : '' }}>Local</option>
                                <option value="intercity" {{ request('type') == 'intercity' ? 'selected' : '' }}>Intercity</option>
                            </select>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                Filter
                            </button>
                            @if(request()->has('search') || request()->has('type'))
                            <a href="{{ route('admin.trains') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                                Clear
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Train Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compartments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Seats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($trains as $train)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $train->train_name }}</div>
                                    <div class="text-sm text-gray-500">Train #{{ $train->train_number }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($train->train_type == 'express') bg-blue-100 text-blue-800
                                    @elseif($train->train_type == 'mail') bg-green-100 text-green-800
                                    @elseif($train->train_type == 'local') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($train->train_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $train->coaches->count() }} compartments</div>
                                <div class="text-xs text-gray-500">
                                    @foreach($train->coaches->take(3) as $coach)
                                        <span class="inline-block bg-gray-100 rounded px-2 py-1 mr-1 mb-1">
                                            {{ $coach->coach_number }}
                                        </span>
                                    @endforeach
                                    @if($train->coaches->count() > 3)
                                        <span class="text-gray-400">+{{ $train->coaches->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $train->coaches->sum('total_seats') }} seats
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($train->status == 'active') bg-green-100 text-green-800
                                    @elseif($train->status == 'inactive') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($train->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.trains.edit', $train) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-green-600 hover:text-green-900">Coaches</a>
                                    <form action="{{ route('admin.trains.destroy', $train) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this train?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No trains found. <a href="{{ route('admin.trains.create') }}" class="text-green-600 hover:text-green-800">Add your first train</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
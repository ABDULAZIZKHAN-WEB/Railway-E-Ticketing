@extends('layouts.railway')

@section('title', 'Add New Train - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">+ Add New Train</h1>
                    <p class="text-gray-600 mt-2">Fill in the details to add a new train to the system</p>
                </div>
                <a href="{{ route('admin.trains') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    ← Back to Trains
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.trains.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Train Number -->
                    <div>
                        <label for="train_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Train Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="train_number" id="train_number" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('train_number') }}">
                        @error('train_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Train Name -->
                    <div>
                        <label for="train_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Train Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="train_name" id="train_name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('train_name') }}">
                        @error('train_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Train Type -->
                    <div>
                        <label for="train_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Train Type <span class="text-red-500">*</span>
                        </label>
                        <select name="train_type" id="train_type" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Train Type</option>
                            <option value="express" {{ old('train_type') == 'express' ? 'selected' : '' }}>Express</option>
                            <option value="mail" {{ old('train_type') == 'mail' ? 'selected' : '' }}>Mail</option>
                            <option value="local" {{ old('train_type') == 'local' ? 'selected' : '' }}>Local</option>
                            <option value="intercity" {{ old('train_type') == 'intercity' ? 'selected' : '' }}>Intercity</option>
                        </select>
                        @error('train_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Coaches -->
                    <div>
                        <label for="total_coaches" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Coaches <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="total_coaches" id="total_coaches" min="1" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('total_coaches') }}">
                        @error('total_coaches')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bangla Name (Optional) -->
                    <div>
                        <label for="train_name_bn" class="block text-sm font-medium text-gray-700 mb-2">
                            Train Name (Bangla) <span class="text-gray-500">(Optional)</span>
                        </label>
                        <input type="text" name="train_name_bn" id="train_name_bn"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               value="{{ old('train_name_bn') }}">
                        @error('train_name_bn')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('admin.trains') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        Add Train
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
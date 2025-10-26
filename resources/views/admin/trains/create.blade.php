@extends('layouts.railway')

@section('title', 'Add New Train - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
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
            <form action="{{ route('admin.trains.store') }}" method="POST" id="train-form">
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

                <!-- Compartment Configuration -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Compartment Configuration</h3>
                    <p class="text-gray-600 mb-6">Configure the compartments (coaches) for this train</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-700">Compartments</h4>
                            <button type="button" id="add-compartment" class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition duration-200">
                                + Add Compartment
                            </button>
                        </div>
                        
                        <div id="compartments-container">
                            <!-- Default compartment -->
                            <div class="compartment-item bg-white rounded-lg p-4 mb-4 border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Compartment Type</label>
                                        <select name="compartments[0][seat_class_id]" class="compartment-type w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                                            <option value="">Select Type</option>
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Compartment Number</label>
                                        <input type="text" name="compartments[0][coach_number]" 
                                               class="compartment-number w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                               placeholder="e.g., A1" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Number of Seats</label>
                                        <input type="number" name="compartments[0][total_seats]" min="1" max="80"
                                               class="seat-count w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                               placeholder="e.g., 40" required>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="remove-compartment bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600 transition duration-200">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch seat classes for compartment types
    fetch('/api/seat-classes')
        .then(response => response.json())
        .then(data => {
            const selectElements = document.querySelectorAll('.compartment-type');
            selectElements.forEach(select => {
                data.forEach(seatClass => {
                    const option = document.createElement('option');
                    option.value = seatClass.id;
                    option.textContent = `${seatClass.class_name} (${seatClass.class_code})`;
                    select.appendChild(option);
                });
            });
        })
        .catch(error => console.error('Error fetching seat classes:', error));

    // Add compartment functionality
    document.getElementById('add-compartment').addEventListener('click', function() {
        const container = document.getElementById('compartments-container');
        const compartmentCount = container.querySelectorAll('.compartment-item').length;
        
        const compartmentDiv = document.createElement('div');
        compartmentDiv.className = 'compartment-item bg-white rounded-lg p-4 mb-4 border border-gray-200';
        compartmentDiv.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Compartment Type</label>
                    <select name="compartments[${compartmentCount}][seat_class_id]" class="compartment-type w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Select Type</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Compartment Number</label>
                    <input type="text" name="compartments[${compartmentCount}][coach_number]" 
                           class="compartment-number w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="e.g., A1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Seats</label>
                    <input type="number" name="compartments[${compartmentCount}][total_seats]" min="1" max="80"
                           class="seat-count w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="e.g., 40" required>
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-compartment bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600 transition duration-200">
                        Remove
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(compartmentDiv);
        
        // Populate the new select with seat classes
        fetch('/api/seat-classes')
            .then(response => response.json())
            .then(data => {
                const select = compartmentDiv.querySelector('.compartment-type');
                data.forEach(seatClass => {
                    const option = document.createElement('option');
                    option.value = seatClass.id;
                    option.textContent = `${seatClass.class_name} (${seatClass.class_code})`;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching seat classes:', error));
    });

    // Remove compartment functionality
    document.getElementById('compartments-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-compartment')) {
            const compartmentItem = e.target.closest('.compartment-item');
            if (compartmentItem) {
                compartmentItem.remove();
            }
        }
    });

    // Form submission handling
    document.getElementById('train-form').addEventListener('submit', function(e) {
        // Validate that at least one compartment is added
        const compartments = document.querySelectorAll('.compartment-item');
        if (compartments.length === 0) {
            e.preventDefault();
            alert('Please add at least one compartment.');
            return;
        }
        
        // Validate compartment data
        let isValid = true;
        compartments.forEach((compartment, index) => {
            const type = compartment.querySelector('.compartment-type').value;
            const number = compartment.querySelector('.compartment-number').value;
            const seats = compartment.querySelector('.seat-count').value;
            
            if (!type || !number || !seats) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all compartment details.');
        }
    });
});
</script>
@endsection
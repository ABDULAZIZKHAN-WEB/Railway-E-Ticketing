@extends('layouts.railway')

@section('title', 'Register - Bangladesh Railway E-Ticketing')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50 py-12">
    <div class="max-w-md mx-auto">
        <div class="form-railway fade-in">
            <div class="text-center mb-8">
                <div class="text-4xl mb-4">🚄</div>
                <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                <p class="text-gray-600 mt-2">Join Bangladesh Railway E-Ticketing</p>
            </div>
            
            <form method="POST" action="/register">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           placeholder="01XXXXXXXXX"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           required>
                </div>

                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" required class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 mt-1">
                        <span class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="/terms" class="text-green-600 hover:text-green-800">Terms & Conditions</a> 
                            and <a href="/privacy" class="text-green-600 hover:text-green-800">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-railway">
                    📝 Create Account
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="/login" class="text-green-600 hover:text-green-800 font-medium">Sign in here</a>
                </p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-green-800 mb-2">🎯 Account Benefits</h3>
            <ul class="text-sm text-green-700 space-y-1">
                <li>• Quick booking with saved passenger details</li>
                <li>• Track your booking history and payments</li>
                <li>• Get instant booking confirmations via email</li>
                <li>• Access to exclusive offers and discounts</li>
            </ul>
        </div>
    </div>
</div>
@endsection
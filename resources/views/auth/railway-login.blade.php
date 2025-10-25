@extends('layouts.railway')

@section('title', 'Login - Bangladesh Railway E-Ticketing')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50 py-12">
    <div class="max-w-md mx-auto">
        <div class="form-railway fade-in">
            <div class="text-center mb-8">
                <div class="text-4xl mb-4">🚄</div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-gray-600 mt-2">Sign in to your railway account</p>
            </div>
            
            <form method="POST" action="/login">
                @csrf
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="input-railway @error('email') error @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="input-railway @error('password') error @enderror"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-railway">
                    🔐 Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="/register" class="text-green-600 hover:text-green-800 font-medium">Create one here</a>
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    <a href="/forgot-password" class="hover:text-gray-700">Forgot your password?</a>
                </p>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Security Notice</h3>
                    <div class="mt-1 text-sm text-blue-700">
                        <p>Your account security is important to us. Never share your login credentials with anyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'Print Tickets - Ticket Seller')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🖨️ Print Tickets</h1>
                    <p class="text-gray-600 mt-2">Reprint tickets for customers</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Search for Ticket -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">🔍 Find Ticket to Print</h2>
                
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Method</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option>PNR Number</option>
                            <option>Phone Number</option>
                            <option>Passenger Name</option>
                            <option>Booking ID</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Enter Details</label>
                        <input type="text" placeholder="Enter PNR, phone, or name..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 transition duration-200">
                        🔍 Search Ticket
                    </button>
                </form>

                <!-- Search Results -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-4">Search Results</h3>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-medium text-gray-800">PNR: BD123456789</h4>
                                <p class="text-sm text-gray-600">John Doe • 01712345678</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Confirmed
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <span class="text-gray-600">Route:</span>
                                <span class="font-medium ml-1">Dhaka → Chittagong</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Train:</span>
                                <span class="font-medium ml-1">Suborno Express</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium ml-1">{{ date('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Seat:</span>
                                <span class="font-medium ml-1">A-15 (AC Seat)</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                                🖨️ Print Ticket
                            </button>
                            <button class="flex-1 bg-blue-100 text-blue-700 py-2 px-4 rounded-lg hover:bg-blue-200 transition duration-200">
                                👁️ Preview
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Options & History -->
            <div class="space-y-6">
                <!-- Print Options -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">🖨️ Print Options</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Printer</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option>Counter Printer #1 (HP LaserJet)</option>
                                <option>Counter Printer #2 (Canon)</option>
                                <option>Backup Printer (Epson)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Print Format</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="standard" checked class="mr-3">
                                    <span class="text-sm">Standard Ticket (A4)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="thermal" class="mr-3">
                                    <span class="text-sm">Thermal Receipt</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="mobile" class="mr-3">
                                    <span class="text-sm">Mobile Ticket (QR Code)</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number of Copies</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option>1 Copy</option>
                                <option>2 Copies</option>
                                <option>3 Copies</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="duplicate" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <label for="duplicate" class="ml-2 text-sm text-gray-700">Mark as "DUPLICATE" on reprint</label>
                        </div>
                    </div>
                </div>

                <!-- Recent Print History -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">📋 Recent Print History</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm">PNR: BD123456789</div>
                                <div class="text-xs text-gray-600">John Doe • 2 minutes ago</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-green-600">✓ Printed</div>
                                <div class="text-xs text-gray-500">Standard</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm">PNR: BD123456790</div>
                                <div class="text-xs text-gray-600">Jane Smith • 15 minutes ago</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-green-600">✓ Printed</div>
                                <div class="text-xs text-gray-500">Thermal</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm">PNR: BD123456791</div>
                                <div class="text-xs text-gray-600">Bob Wilson • 1 hour ago</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-red-600">✗ Failed</div>
                                <div class="text-xs text-gray-500">Printer Error</div>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-4 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-200">
                        View Full History
                    </button>
                </div>

                <!-- Printer Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">🖨️ Printer Status</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Counter Printer #1</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Online
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Paper Level</span>
                            <span class="text-green-600 font-medium">85%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Toner Level</span>
                            <span class="text-yellow-600 font-medium">45%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Last Maintenance</span>
                            <span class="text-gray-600">Oct 20, 2025</span>
                        </div>
                    </div>

                    <button class="w-full mt-4 bg-blue-100 text-blue-700 py-2 px-4 rounded-lg hover:bg-blue-200 transition duration-200">
                        🔧 Printer Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
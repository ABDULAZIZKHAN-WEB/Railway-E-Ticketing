@extends('layouts.railway')

@section('title', 'Contact Us - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">📞 Contact Us</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Need help with your railway booking? We're here to assist you 24/7.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send us a Message</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option>Booking Issue</option>
                            <option>Payment Problem</option>
                            <option>Refund Request</option>
                            <option>Technical Support</option>
                            <option>General Inquiry</option>
                            <option>Complaint</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Please describe your issue or inquiry in detail..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-green-700 hover:to-red-700 transition duration-200">
                        📧 Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Quick Contact -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Quick Contact</h2>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="text-2xl mr-4">📞</div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Hotline</h3>
                                <p class="text-gray-600">16318 (24/7 Support)</p>
                                <p class="text-sm text-gray-500">Toll-free from any operator</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-2xl mr-4">📧</div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Email Support</h3>
                                <p class="text-gray-600">info@railway.gov.bd</p>
                                <p class="text-sm text-gray-500">Response within 24 hours</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-2xl mr-4">💬</div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Live Chat</h3>
                                <p class="text-gray-600">Available 24/7</p>
                                <button class="text-green-600 hover:text-green-800 text-sm font-medium">Start Chat →</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office Locations -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Office Locations</h2>
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-semibold text-gray-800">Head Office</h3>
                            <p class="text-gray-600">Bangladesh Railway Building</p>
                            <p class="text-gray-600">Rail Bhaban, Dhaka-1000</p>
                            <p class="text-sm text-gray-500">Open: 9:00 AM - 5:00 PM</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Chittagong Office</h3>
                            <p class="text-gray-600">Railway Station Road</p>
                            <p class="text-gray-600">Chittagong-4000</p>
                            <p class="text-sm text-gray-500">Open: 9:00 AM - 5:00 PM</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Sylhet Office</h3>
                            <p class="text-gray-600">Railway Station Complex</p>
                            <p class="text-gray-600">Sylhet-3100</p>
                            <p class="text-sm text-gray-500">Open: 9:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contacts -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-red-800 mb-4">🚨 Emergency Contacts</h3>
                    <div class="space-y-2 text-sm text-red-700">
                        <p><strong>Railway Police:</strong> 999</p>
                        <p><strong>Medical Emergency:</strong> 16263</p>
                        <p><strong>Fire Service:</strong> 16163</p>
                        <p><strong>Control Room:</strong> +880-2-9556031</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">❓ Frequently Asked Questions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">How can I cancel my booking?</h3>
                    <p class="text-gray-600 text-sm mb-4">You can cancel your booking online through your dashboard or by calling our hotline 16318.</p>
                    
                    <h3 class="font-semibold text-gray-800 mb-2">When will I get my refund?</h3>
                    <p class="text-gray-600 text-sm mb-4">Refunds are processed within 7-10 working days after cancellation approval.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Can I change my travel date?</h3>
                    <p class="text-gray-600 text-sm mb-4">Yes, you can modify your booking up to 4 hours before departure, subject to availability.</p>
                    
                    <h3 class="font-semibold text-gray-800 mb-2">What documents do I need for travel?</h3>
                    <p class="text-gray-600 text-sm mb-4">You need a valid photo ID (NID, Passport, or Driving License) and your e-ticket.</p>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="/faq" class="text-green-600 hover:text-green-800 font-medium">View All FAQs →</a>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.railway')

@section('title', 'FAQ - Bangladesh Railway')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">❓ Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600">Find quick answers to the most common questions</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">How do I book a train ticket online?</h3>
                <p class="text-gray-600">You can book tickets by searching for trains on our homepage, selecting your preferred train and class, choosing seats, and completing the payment process.</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">What payment methods are accepted?</h3>
                <p class="text-gray-600">We accept all major credit/debit cards, mobile banking (bKash, Nagad, Rocket), and internet banking through our secure payment gateway.</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Can I cancel my booking?</h3>
                <p class="text-gray-600">Yes, you can cancel your booking up to 4 hours before departure. Cancellation charges may apply based on the time of cancellation.</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">How do I get my refund?</h3>
                <p class="text-gray-600">Refunds are processed automatically to your original payment method within 7-10 working days after cancellation approval.</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">What documents do I need for travel?</h3>
                <p class="text-gray-600">You need a valid photo ID (National ID, Passport, or Driving License) and your e-ticket (printed or mobile) for travel.</p>
            </div>
        </div>
    </div>
</div>
@endsection
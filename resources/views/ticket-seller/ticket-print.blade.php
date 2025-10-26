<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - {{ $booking->booking_reference }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .ticket {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0 0 5px 0;
        }
        .header p {
            color: #666;
            margin: 0;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h2 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin-top: 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .info-value {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .fare-summary {
            margin-left: auto;
            max-width: 300px;
        }
        .fare-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total {
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .print-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 14px;
        }
        .duplicate-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 72px;
            font-weight: bold;
            color: rgba(255, 0, 0, 0.2);
            pointer-events: none;
            z-index: 1000;
        }
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .ticket {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        @if(request('duplicate', false))
        <div class="duplicate-stamp">DUPLICATE</div>
        @endif
        
        <div class="header">
            <h1>Bangladesh Railway</h1>
            <p>E-Ticket Confirmation</p>
            <p>Booking Reference: {{ $booking->booking_reference }}</p>
        </div>

        <div class="info-section">
            <h2>Booking Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Booking Date:</span>
                    <span class="info-value">{{ $booking->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ ucfirst($booking->booking_status) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment:</span>
                    <span class="info-value">{{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>Journey Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Route:</span>
                    <span class="info-value">
                        {{ $booking->fromStation->station_name ?? 'N/A' }} → 
                        {{ $booking->toStation->station_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Train:</span>
                    <span class="info-value">
                        {{ $booking->trainSchedule->train->train_name ?? 'N/A' }} 
                        (#{{ $booking->trainSchedule->train->train_number ?? 'N/A' }})
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ $booking->journey_date->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Departure:</span>
                    <span class="info-value">{{ $booking->trainSchedule->departure_time->format('H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>Passenger Information</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>ID Type</th>
                        <th>ID Number</th>
                        <th>Seat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->bookingPassengers as $passenger)
                    <tr>
                        <td>{{ $passenger->passenger_name }}</td>
                        <td>{{ $passenger->age }}</td>
                        <td>{{ ucfirst($passenger->gender) }}</td>
                        <td>
                            @if($passenger->id_type == 'nid')
                                National ID
                            @elseif($passenger->id_type == 'passport')
                                Passport
                            @elseif($passenger->id_type == 'birth_certificate')
                                Birth Certificate
                            @else
                                {{ ucfirst($passenger->id_type) }}
                            @endif
                        </td>
                        <td>{{ $passenger->id_number }}</td>
                        <td>
                            {{ $passenger->seat->coach->coach_number ?? 'N/A' }}-{{ $passenger->seat->seat_number ?? 'N/A' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="info-section">
            <h2>Fare Details</h2>
            <div class="fare-summary">
                <div class="fare-item">
                    <span>Base Fare:</span>
                    <span>৳{{ number_format($booking->total_amount - 20 - ($booking->total_amount * 0.05), 2) }}</span>
                </div>
                <div class="fare-item">
                    <span>VAT (5%):</span>
                    <span>৳{{ number_format($booking->total_amount * 0.05, 2) }}</span>
                </div>
                <div class="fare-item">
                    <span>Service Charge:</span>
                    <span>৳20.00</span>
                </div>
                <div class="fare-item total">
                    <span>Total Amount:</span>
                    <span class="text-green-600">৳{{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="print-footer">
            <p>Thank you for traveling with Bangladesh Railway</p>
            <p>Have a safe journey!</p>
            <p>{{ now()->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
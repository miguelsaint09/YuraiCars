<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $rental->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px;
            vertical-align: top;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .details-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .details-row {
            display: table-row;
        }
        .details-label {
            display: table-cell;
            padding: 5px;
            font-weight: bold;
            width: 150px;
            color: #666;
        }
        .details-value {
            display: table-cell;
            padding: 5px;
        }
        .rental-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .rental-table th, .rental-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .rental-table th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .features {
            margin-top: 10px;
        }
        .feature-tag {
            display: inline-block;
            background: #f0f0f0;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>Rent-A-Car</h2>
        <p>Invoice #{{ $rental->id }}</p>
    </div>

    <div class="section">
        <h2>Customer Information</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Full Name:</div>
                <div class="details-value">{{ $user->profile->first_name }} {{ $user->profile->last_name }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Email:</div>
                <div class="details-value">{{ $user->email }}</div>
            </div>
            @if($user->profile)
            <div class="details-row">
                <div class="details-label">Phone:</div>
                <div class="details-value">{{ $user->profile->phone ?? 'Not provided' }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Address:</div>
                <div class="details-value">{{ $user->profile->address ?? 'Not provided' }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Vehicle Information</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Vehicle:</div>
                <div class="details-value">{{ $vehicle->name }} - {{ $vehicle->year }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Make & Model:</div>
                <div class="details-value">{{ $vehicle->make }} {{ $vehicle->model }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Category:</div>
                <div class="details-value">{{ $vehicle->category }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">License Plate:</div>
                <div class="details-value">{{ $vehicle->license_plate }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Color:</div>
                <div class="details-value">{{ $vehicle->color }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Transmission:</div>
                <div class="details-value">{{ ucfirst($vehicle->transmission) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Fuel Type:</div>
                <div class="details-value">{{ ucfirst($vehicle->fuel_type) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Seats:</div>
                <div class="details-value">{{ $vehicle->seats }}</div>
            </div>
            @if($vehicle->features)
            <div class="details-row">
                <div class="details-label">Features:</div>
                <div class="details-value">
                    <div class="features">
                        @foreach($vehicle->features as $feature)
                            <span class="feature-tag">{{ $feature }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Rental Details</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Pickup Location:</div>
                <div class="details-value">{{ $rental->pickup_location }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Drop-off Location:</div>
                <div class="details-value">{{ $rental->dropoff_location }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Start Time:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->start_time)->format('M d, Y h:i A') }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">End Time:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->end_time)->format('M d, Y h:i A') }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Total Days:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Status:</div>
                <div class="details-value">{{ ucfirst($rental->status) }}</div>
            </div>
        </div>

        <table class="rental-table">
            <tr>
                <th>Description</th>
                <th>Days</th>
                <th>Daily Rate</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>
                    {{ $vehicle->name }} - {{ $vehicle->year }}<br>
                    <small>{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</td>
                <td>${{ number_format($vehicle->price_per_day, 2) }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Payment Information</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Payment Method:</div>
                <div class="details-value">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Payment Status:</div>
                <div class="details-value">{{ ucfirst($payment->status) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Payment Date:</div>
                <div class="details-value">{{ $payment->created_at->format('M d, Y h:i A') }}</div>
            </div>
            @if($payment->transaction_id)
            <div class="details-row">
                <div class="details-label">Transaction ID:</div>
                <div class="details-value">{{ $payment->transaction_id }}</div>
            </div>
            @endif
        </div>

        <div class="total">
            <h3>Total Amount: ${{ number_format($payment->amount, 2) }}</h3>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for choosing our service!</p>
        <p>For any questions, please contact our support team.</p>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
    </div>
</body>
</html> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura - YuraiCars</title>
    <style>
        @page {
            margin: 0;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
        }

        .invoice-container {
            padding: 40px;
            background: #ffffff;
        }

        .invoice-header {
            padding-bottom: 20px;
            border-bottom: 2px solid #6366f1;
            margin-bottom: 30px;
        }

        .company-info {
            float: left;
            width: 40%;
        }

        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .company-details {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.4;
        }

        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .invoice-date {
            font-size: 14px;
            color: #4b5563;
        }

        .client-info {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .client-details {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.4;
        }

        .rental-details {
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .rental-details th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            color: #1a1a1a;
            border-bottom: 2px solid #e5e7eb;
        }

        .rental-details td {
            padding: 12px;
            font-size: 14px;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }

        .vehicle-name {
            font-weight: bold;
            color: #1a1a1a;
        }

        .vehicle-details {
            font-size: 12px;
            color: #6b7280;
        }

        .total-section {
            margin-top: 30px;
            text-align: right;
        }

        .total-row {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .total-label {
            color: #4b5563;
            margin-right: 20px;
        }

        .total-amount {
            font-weight: bold;
            color: #1a1a1a;
        }

        .grand-total {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #6366f1;
            font-size: 18px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        .payment-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-success {
            background: #dcfce7;
            color: #166534;
        }

        .rental-period {
            margin: 20px 0;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 8px;
        }

        .rental-period-title {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .rental-period-details {
            font-size: 14px;
            color: #4b5563;
            display: flex;
            justify-content: space-between;
        }

        .qr-code {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="company-info">
                <div class="logo">YuraiCars</div>
                <div class="company-details">
                    Santo Domingo<br>
                    República Dominicana<br>
                    Tel: +1 (809) 555-0123<br>
                    info@yuraicars.com
                </div>
            </div>
            <div class="invoice-info">
                <div class="invoice-number">Factura #{{ substr($rental->id, 0, 8) }}</div>
                <div class="invoice-date">
                    Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                    Hora: {{ \Carbon\Carbon::now()->format('h:i A') }}
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="client-info">
            <div class="section-title">Cliente</div>
            <div class="client-details">
                {{ $user->name }}<br>
                {{ $user->email }}<br>
                ID: {{ substr($user->id, 0, 8) }}
            </div>
        </div>

        <div class="rental-period">
            <div class="rental-period-title">Período de Alquiler</div>
            <div class="rental-period-details">
                <div>
                    <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($rental->start_time)->format('d/m/Y h:i A') }}<br>
                    <strong>Fin:</strong> {{ \Carbon\Carbon::parse($rental->end_time)->format('d/m/Y h:i A') }}
                </div>
                <div>
                    <strong>Duración:</strong> {{ round(\Carbon\Carbon::parse($rental->start_time)->floatDiffInDays(\Carbon\Carbon::parse($rental->end_time))) }} días
                </div>
            </div>
        </div>

        <table class="rental-details">
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Días</th>
                    <th>Precio por Día</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="vehicle-name">{{ $vehicle->name }} - {{ $vehicle->year }}</div>
                        <div class="vehicle-details">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</div>
                    </td>
                    <td>{{ round(\Carbon\Carbon::parse($rental->start_time)->floatDiffInDays(\Carbon\Carbon::parse($rental->end_time))) }}</td>
                    <td>${{ number_format($vehicle->price_per_day, 2) }} DOP</td>
                    <td>${{ number_format($payment->amount, 2) }} DOP</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <span class="total-amount">${{ number_format($payment->amount, 2) }} DOP</span>
            </div>
            <div class="total-row">
                <span class="total-label">ITBIS (18%):</span>
                <span class="total-amount">${{ number_format($payment->amount * 0.18, 2) }} DOP</span>
            </div>
            <div class="total-row grand-total">
                <span class="total-label">Total:</span>
                <span class="total-amount">${{ number_format($payment->amount * 1.18, 2) }} DOP</span>
            </div>
        </div>

        <div class="footer">
            <p>Gracias por confiar en YuraiCars para su alquiler de vehículos.</p>
            <p>Esta factura fue generada electrónicamente y es válida sin firma.</p>
        </div>
    </div>
</body>
</html> 
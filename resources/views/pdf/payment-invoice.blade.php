<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura de Pago - {{ $payment->is_initial_payment ? 'Inicial' : 'Adicional' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 18px;
            color: #666;
        }
        
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-info div {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .invoice-number, .invoice-date {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 15px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 5px;
        }
        
        .customer-info, .vehicle-info {
            margin-bottom: 25px;
        }
        
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        
        .rental-period {
            background-color: #F3F4F6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .rental-period-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4F46E5;
        }
        
        .rental-period-details {
            display: table;
            width: 100%;
        }
        
        .rental-period-details > div {
            display: table-cell;
            width: 50%;
        }
        
        .payment-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .payment-details th, .payment-details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .payment-details th {
            background-color: #F9FAFB;
            font-weight: bold;
            color: #374151;
        }
        
        .payment-type {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .payment-type.initial {
            background-color: #DBEAFE;
            color: #1D4ED8;
        }
        
        .payment-type.additional {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .total-row {
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
            border-top: 2px solid #4F46E5;
            padding-top: 10px;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #6B7280;
            font-size: 12px;
            border-top: 1px solid #E5E7EB;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">YuraiCars</div>
        <div class="invoice-title">
            Factura de Pago {{ $payment->is_initial_payment ? 'Inicial' : 'Adicional' }}
        </div>
    </div>

    <div class="invoice-info">
        <div>
            <div class="invoice-number"><strong>Número de Factura:</strong> {{ $payment->is_initial_payment ? 'INI-' : 'ADD-' }}{{ substr($payment->id, 0, 8) }}</div>
            <div class="invoice-date"><strong>Fecha de Emisión:</strong> {{ $payment->created_at->format('d/m/Y') }}</div>
        </div>
        <div style="text-align: right;">
            <div class="invoice-number"><strong>ID del Alquiler:</strong> {{ substr($rental->id, 0, 8) }}</div>
            <div class="invoice-date"><strong>Estado del Pago:</strong> {{ $payment->formatted_status }}</div>
        </div>
    </div>

    <div class="customer-info">
        <div class="section-title">Información del Cliente</div>
        <div class="info-row">
            <span class="info-label">Cliente:</span>
            {{ $user->email }}
        </div>
        @if($user->profile)
        <div class="info-row">
            <span class="info-label">Nombre:</span>
            {{ $user->profile->first_name }} {{ $user->profile->last_name }}
        </div>
        @if($user->profile->phone)
        <div class="info-row">
            <span class="info-label">Teléfono:</span>
            {{ $user->profile->phone }}
        </div>
        @endif
        @endif
    </div>

    <div class="vehicle-info">
        <div class="section-title">Información del Vehículo</div>
        <div class="info-row">
            <span class="info-label">Vehículo:</span>
            {{ $vehicle->name }} - {{ $vehicle->year }}
        </div>
        <div class="info-row">
            <span class="info-label">Categoría:</span>
            {{ $vehicle->category }}
        </div>
        <div class="info-row">
            <span class="info-label">Placa:</span>
            {{ $vehicle->license_plate }}
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
                <strong>Duración:</strong> {{ $rental->duration_days }} días<br>
                @if($payment->additional_days)
                <strong>Días Adicionales:</strong> {{ $payment->additional_days }} días
                @endif
            </div>
        </div>
    </div>

    <table class="payment-details">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Tipo de Pago</th>
                <th>Método de Pago</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $payment->formatted_description }}</td>
                <td>
                    <span class="payment-type {{ $payment->payment_type }}">
                        {{ $payment->is_initial_payment ? 'Inicial' : 'Adicional' }}
                    </span>
                </td>
                <td>{{ $payment->formatted_payment_method }}</td>
                <td>${{ number_format($payment->amount, 2) }} DOP</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <strong>Subtotal: ${{ number_format($payment->amount, 2) }} DOP</strong>
        </div>
        <div class="total-amount">
            Total Pagado: ${{ number_format($payment->amount, 2) }} DOP
        </div>
    </div>

    <div class="footer">
        <p>Gracias por elegir YuraiCars para sus necesidades de alquiler de vehículos.</p>
        <p>Esta factura fue generada el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html> 
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura Completa - Alquiler {{ substr($rental->id, 0, 8) }}</title>
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
            font-size: 32px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 20px;
            color: #666;
        }
        
        .invoice-info {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-info .left {
            float: left;
            width: 48%;
        }
        
        .invoice-info .right {
            float: right;
            width: 48%;
            text-align: right;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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
            width: 100%;
        }
        
        .rental-period-details .left {
            float: left;
            width: 48%;
        }
        
        .rental-period-details .right {
            float: right;
            width: 48%;
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
        
        .payment-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .payment-status.success {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .payment-status.pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .payment-status.failed {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .summary-section {
            background-color: #F9FAFB;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        .summary-row {
            width: 100%;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .summary-label {
            float: left;
            font-weight: bold;
        }
        
        .summary-value {
            float: right;
        }
        
        .total-amount {
            border-top: 2px solid #4F46E5;
            padding-top: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
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
        <div class="invoice-title">Factura Completa del Alquiler</div>
    </div>

    <div class="invoice-info clearfix">
        <div class="left">
            <div class="invoice-number"><strong>Factura Nº:</strong> COMP-{{ substr($rental->id, 0, 8) }}</div>
            <div class="invoice-date"><strong>Fecha de Emisión:</strong> {{ now()->format('d/m/Y') }}</div>
        </div>
        <div class="right">
            <div class="invoice-number"><strong>ID del Alquiler:</strong> {{ substr($rental->id, 0, 8) }}</div>
            <div class="invoice-date"><strong>Estado del Alquiler:</strong> {{ ucfirst($rental->status) }}</div>
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
            <span class="info-label">Marca:</span>
            {{ $vehicle->make }}
        </div>
        <div class="info-row">
            <span class="info-label">Modelo:</span>
            {{ $vehicle->model }}
        </div>
        <div class="info-row">
            <span class="info-label">Categoría:</span>
            {{ $vehicle->category }}
        </div>
        <div class="info-row">
            <span class="info-label">Placa:</span>
            {{ $vehicle->license_plate }}
        </div>
        <div class="info-row">
            <span class="info-label">Precio por día:</span>
            ${{ number_format($vehicle->price_per_day, 2) }} DOP
        </div>
    </div>

    <div class="rental-period">
        <div class="rental-period-title">Detalles del Alquiler</div>
        <div class="rental-period-details clearfix">
            <div class="left">
                <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($rental->start_time)->format('d/m/Y h:i A') }}<br>
                <strong>Fin:</strong> {{ \Carbon\Carbon::parse($rental->end_time)->format('d/m/Y h:i A') }}<br>
                <strong>Duración:</strong> {{ $rental->duration_days }} días
            </div>
            <div class="right">
                <strong>Lugar de Recogida:</strong> {{ $rental->pickup_location }}<br>
                <strong>Lugar de Devolución:</strong> {{ $rental->dropoff_location }}
            </div>
        </div>
    </div>

    <div class="section-title">Historial de Pagos</div>
    <table class="payment-details">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Método de Pago</th>
                <th>Estado</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments->sortBy('created_at') as $payment)
            <tr>
                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $payment->formatted_description }}</td>
                <td>
                    <span class="payment-type {{ $payment->payment_type }}">
                        {{ $payment->is_initial_payment ? 'Inicial' : 'Adicional' }}
                    </span>
                </td>
                <td>{{ $payment->formatted_payment_method }}</td>
                <td>
                    <span class="payment-status {{ $payment->status }}">
                        {{ $payment->formatted_status }}
                    </span>
                </td>
                <td>${{ number_format($payment->amount, 2) }} DOP</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="summary-row clearfix">
            <div class="summary-label">Monto Total del Alquiler:</div>
            <div class="summary-value">${{ number_format($rental->total_amount, 2) }} DOP</div>
        </div>
        <div class="summary-row clearfix">
            <div class="summary-label">Total Pagado:</div>
            <div class="summary-value">${{ number_format($rental->paid_amount, 2) }} DOP</div>
        </div>
        <div class="summary-row clearfix">
            <div class="summary-label">Monto Pendiente:</div>
            <div class="summary-value">${{ number_format($rental->pending_amount, 2) }} DOP</div>
        </div>
        <div class="summary-row clearfix">
            <div class="summary-label">Número de Pagos:</div>
            <div class="summary-value">{{ $payments->count() }} pago(s)</div>
        </div>
        <div class="summary-row total-amount clearfix">
            <div class="summary-label">Estado de Pagos:</div>
            <div class="summary-value">{{ $rental->payment_status }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por elegir YuraiCars para sus necesidades de alquiler de vehículos.</p>
        <p>Esta factura completa fue generada el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Para consultas sobre esta factura, contacte a nuestro equipo de atención al cliente.</p>
    </div>
</body>
</html> 
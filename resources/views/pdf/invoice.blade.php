<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $rental->id }}</title>
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
        <h1>FACTURA</h1>
        <h2>YuraiCars</h2>
        <p>Factura #{{ $rental->id }}</p>
    </div>

    <div class="section">
        <h2>Información del Cliente</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Nombre:</div>
                <div class="details-value">{{ $user->profile->first_name }} {{ $user->profile->last_name }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Correo:</div>
                <div class="details-value">{{ $user->email }}</div>
            </div>
            @if($user->profile)
            <div class="details-row">
                <div class="details-label">Teléfono:</div>
                <div class="details-value">{{ $user->profile->phone ?? 'No proporcionado' }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Dirección:</div>
                <div class="details-value">{{ $user->profile->address ?? 'No proporcionada' }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Información del Vehículo</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Vehículo:</div>
                <div class="details-value">{{ $vehicle->name }} - {{ $vehicle->year }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Marca y Modelo:</div>
                <div class="details-value">{{ $vehicle->make }} {{ $vehicle->model }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Categoría:</div>
                <div class="details-value">{{ $vehicle->category }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Matrícula:</div>
                <div class="details-value">{{ $vehicle->license_plate }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Color:</div>
                <div class="details-value">{{ $vehicle->color }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Transmisión:</div>
                <div class="details-value">{{ ucfirst($vehicle->transmission) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Combustible:</div>
                <div class="details-value">{{ ucfirst($vehicle->fuel_type) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Asientos:</div>
                <div class="details-value">{{ $vehicle->seats }}</div>
            </div>
            @if($vehicle->features)
            <div class="details-row">
                <div class="details-label">Características:</div>
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
        <h2>Detalles del Alquiler</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Lugar de Recogida:</div>
                <div class="details-value">{{ $rental->pickup_location }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Lugar de Devolución:</div>
                <div class="details-value">{{ $rental->dropoff_location }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Fecha de Inicio:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->start_time)->format('d M, Y h:i A') }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Fecha de Fin:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->end_time)->format('d M, Y h:i A') }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Total de Días:</div>
                <div class="details-value">{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Estado:</div>
                <div class="details-value">{{ match($rental->status) {
                    'selected' => 'Seleccionado',
                    'pending' => 'Pendiente',
                    'confirmed' => 'Confirmado',
                    'approved' => 'Aprobado',
                    'rejected' => 'Rechazado',
                    'active' => 'Activo',
                    'completed' => 'Completado',
                    'cancelled' => 'Cancelado',
                    default => ucfirst($rental->status)
                } }}</div>
            </div>
        </div>

        <table class="rental-table">
            <tr>
                <th>Descripción</th>
                <th>Días</th>
                <th>Tarifa Diaria</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>
                    {{ $vehicle->name }} - {{ $vehicle->year }}<br>
                    <small>{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</td>
                <td>${{ number_format($vehicle->price_per_day, 2) }} DOP</td>
                <td>${{ number_format($payment->amount, 2) }} DOP</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Información de Pago</h2>
        <div class="details-grid">
            <div class="details-row">
                <div class="details-label">Método de Pago:</div>
                <div class="details-value">{{ match($payment->payment_method) {
                    'credit_card' => 'Tarjeta de Crédito',
                    'debit_card' => 'Tarjeta de Débito',
                    'cash' => 'Efectivo',
                    default => ucfirst(str_replace('_', ' ', $payment->payment_method))
                } }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Estado del Pago:</div>
                <div class="details-value">{{ match($payment->status) {
                    'pending' => 'Pendiente',
                    'success' => 'Pagado',
                    'failed' => 'Fallido',
                    'canceled' => 'Cancelado',
                    'refunded' => 'Reembolsado',
                    default => ucfirst($payment->status)
                } }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Fecha de Pago:</div>
                <div class="details-value">{{ $payment->created_at->format('d M, Y h:i A') }}</div>
            </div>
            @if($payment->transaction_id)
            <div class="details-row">
                <div class="details-label">ID de Transacción:</div>
                <div class="details-value">{{ $payment->transaction_id }}</div>
            </div>
            @endif
        </div>

        <div class="total">
            <h3>Monto Total: ${{ number_format($payment->amount, 2) }} DOP</h3>
        </div>
    </div>

    <div class="footer">
        <p>¡Gracias por elegir nuestro servicio!</p>
        <p>Para cualquier consulta, contacte a nuestro equipo de soporte.</p>
        <p>Generado el: {{ now()->format('d M, Y h:i A') }}</p>
    </div>
</body>
</html>
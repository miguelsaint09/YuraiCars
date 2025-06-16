<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $rental->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 40px;
            font-size: 14px;
            color: #1f2937;
            background: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            position: relative;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }

        .header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #4f46e5;
            margin: 0 0 5px 0;
        }

        .header p {
            font-size: 16px;
            color: #6b7280;
            margin: 0;
        }

        .invoice-info {
            margin-bottom: 40px;
            background: #f9fafb;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .section {
            margin-bottom: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section h2 {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
            padding: 15px 25px;
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .details-grid {
            padding: 25px;
        }

        .details-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .details-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .details-label {
            width: 200px;
            font-weight: 500;
            color: #4b5563;
        }

        .details-value {
            flex: 1;
            color: #111827;
        }

        .rental-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
        }

        .rental-table th {
            background: #f3f4f6;
            padding: 12px 20px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .rental-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
        }

        .rental-table tr:last-child td {
            border-bottom: none;
        }

        .total {
            text-align: right;
            margin-top: 30px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .total h3 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
            color: #6b7280;
        }

        .footer p {
            margin: 5px 0;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .feature-tag {
            background: #eef2ff;
            color: #4f46e5;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.success {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.cancelled {
            background: #f3f4f6;
            color: #374151;
        }

        .status-badge.refunded {
            background: #dbeafe;
            color: #1e40af;
        }

        .payment-method {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: #f3f4f6;
            border-radius: 6px;
            font-weight: 500;
        }

        .payment-method svg {
            width: 16px;
            height: 16px;
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
                <div class="details-value">{{ round(\Carbon\Carbon::parse($rental->start_time)->floatDiffInDays(\Carbon\Carbon::parse($rental->end_time))) }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Estado:</div>
                <div class="details-value">
                    <span class="status-badge {{ $rental->status }}">
                        {{ match($rental->status) {
                            'selected' => 'Seleccionado',
                            'pending' => 'Pendiente',
                            'confirmed' => 'Confirmado',
                            'approved' => 'Aprobado',
                            'rejected' => 'Rechazado',
                            'active' => 'Activo',
                            'completed' => 'Completado',
                            'cancelled' => 'Cancelado',
                            default => ucfirst($rental->status)
                        } }}
                    </span>
                </div>
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
                    <small style="color: #6b7280;">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</small>
                </td>
                <td>{{ round(\Carbon\Carbon::parse($rental->start_time)->floatDiffInDays(\Carbon\Carbon::parse($rental->end_time))) }}</td>
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
                <div class="details-value">
                    <span class="payment-method">
                        @if($payment->payment_method === 'credit_card')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 2v2h16V6H4zm0 4v8h16v-8H4z"/>
                            </svg>
                        @elseif($payment->payment_method === 'debit_card')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 2v2h16V6H4zm0 4v8h16v-8H4z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                        @endif
                        {{ match($payment->payment_method) {
                            'credit_card' => 'Tarjeta de Crédito',
                            'debit_card' => 'Tarjeta de Débito',
                            'cash' => 'Efectivo',
                            default => ucfirst(str_replace('_', ' ', $payment->payment_method))
                        } }}
                    </span>
                </div>
            </div>
            <div class="details-row">
                <div class="details-label">Estado del Pago:</div>
                <div class="details-value">
                    <span class="status-badge {{ $payment->status }}">
                        {{ match($payment->status) {
                            'pending' => 'Pendiente',
                            'success' => 'Pagado',
                            'failed' => 'Fallido',
                            'canceled' => 'Cancelado',
                            'refunded' => 'Reembolsado',
                            default => ucfirst($payment->status)
                        } }}
                    </span>
                </div>
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
        <p>¡Gracias por elegir YuraiCars!</p>
        <p>Para cualquier consulta, contacte a nuestro equipo de soporte.</p>
        <p>Generado el: {{ now()->format('d M, Y h:i A') }}</p>
    </div>
</body>
</html>
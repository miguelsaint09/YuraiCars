<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'additional_days' => 'integer',
    ];

    // relations
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    // Verificar si es pago inicial
    public function getIsInitialPaymentAttribute(): bool
    {
        return $this->payment_type === 'initial';
    }

    // Verificar si es pago adicional
    public function getIsAdditionalPaymentAttribute(): bool
    {
        return $this->payment_type === 'additional';
    }

    // Obtener descripción formateada
    public function getFormattedDescriptionAttribute(): string
    {
        if ($this->is_initial_payment) {
            return 'Pago inicial del alquiler';
        }

        return $this->description ?? 'Pago adicional';
    }

    // Obtener estado formateado
    public function getFormattedStatusAttribute(): string
    {
        return match ($this->status) {
            'success' => 'Exitoso',
            'pending' => 'Pendiente',
            'failed' => 'Fallido',
            default => 'Desconocido',
        };
    }

    // Obtener método de pago formateado
    public function getFormattedPaymentMethodAttribute(): string
    {
        return match ($this->payment_method) {
            'credit_card' => 'Tarjeta de Crédito',
            'debit_card' => 'Tarjeta de Débito',
            'cash' => 'Efectivo',
            'bank_transfer' => 'Transferencia Bancaria',
            'pending' => 'Pendiente',
            default => 'Otro',
        };
    }

    // Formatear monto
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2) . ' DOP';
    }

    // Marcar como exitoso
    public function markAsSuccessful(string $paymentMethod = null): void
    {
        $this->update([
            'status' => 'success',
            'payment_method' => $paymentMethod ?? $this->payment_method,
        ]);
    }

    // Marcar como fallido
    public function markAsFailed(): void
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    // Scopes
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeInitial($query)
    {
        return $query->where('payment_type', 'initial');
    }

    public function scopeAdditional($query)
    {
        return $query->where('payment_type', 'additional');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Mantener compatibilidad con código existente
    public function payment()
    {
        return $this->payments()->where('payment_type', 'initial')->first();
    }

    // Obtener pago inicial
    public function getInitialPaymentAttribute()
    {
        return $this->payments()->where('payment_type', 'initial')->first();
    }

    // Obtener pagos adicionales
    public function getAdditionalPaymentsAttribute()
    {
        return $this->payments()->where('payment_type', 'additional')->get();
    }

    // Calcular duración en días
    public function getDurationDaysAttribute(): int
    {
        if ($this->start_time && $this->end_time) {
            return max($this->start_time->diffInDays($this->end_time), 1);
        }
        return 1;
    }

    // Calcular monto total
    public function getTotalAmountAttribute(): float
    {
        if ($this->start_time && $this->end_time && $this->vehicle) {
            return $this->duration_days * $this->vehicle->price_per_day;
        }
        return 0;
    }

    // Obtener monto total pagado (todos los pagos)
    public function getPaidAmountAttribute(): float
    {
        return $this->payments()->where('status', 'success')->sum('amount');
    }

    // Calcular monto pendiente
    public function getPendingAmountAttribute(): float
    {
        return max($this->total_amount - $this->paid_amount, 0);
    }

    // Verificar si el rental está completamente pagado
    public function getIsFullyPaidAttribute(): bool
    {
        return $this->pending_amount <= 0;
    }

    // Calcular monto adicional al extender fecha final
    public function calculateAdditionalAmount(Carbon $newEndTime): float
    {
        if (!$this->end_time || !$this->vehicle) {
            return 0;
        }

        $originalEnd = $this->end_time;
        
        if ($newEndTime->gt($originalEnd)) {
            $additionalDays = $originalEnd->diffInDays($newEndTime);
            return $additionalDays * $this->vehicle->price_per_day;
        }

        return 0;
    }

    // Crear pago adicional
    public function createAdditionalPayment(float $amount, int $additionalDays, string $description = null): Payment
    {
        return $this->payments()->create([
            'amount' => $amount,
            'payment_type' => 'additional',
            'description' => $description ?? "Pago adicional por {$additionalDays} día(s) extra(s)",
            'additional_days' => $additionalDays,
            'payment_method' => 'pending', // Se actualizará cuando se procese
            'status' => 'pending',
        ]);
    }

    // Formatear monto para mostrar
    public function formatAmount(float $amount): string
    {
        return '$' . number_format($amount, 2) . ' DOP';
    }

    // Obtener estado del pago general
    public function getPaymentStatusAttribute(): string
    {
        $totalPaid = $this->paid_amount;
        $totalAmount = $this->total_amount;

        if ($totalPaid <= 0) {
            return 'Sin pagos';
        } elseif ($totalPaid >= $totalAmount) {
            return 'Completamente pagado';
        } else {
            return 'Parcialmente pagado';
        }
    }

    // Obtener resumen de pagos
    public function getPaymentSummaryAttribute(): array
    {
        return [
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'pending_amount' => $this->pending_amount,
            'payments_count' => $this->payments()->count(),
            'successful_payments_count' => $this->payments()->where('status', 'success')->count(),
        ];
    }
}

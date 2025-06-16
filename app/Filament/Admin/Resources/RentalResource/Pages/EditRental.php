<?php

namespace App\Filament\Admin\Resources\RentalResource\Pages;

use App\Filament\Admin\Resources\RentalResource;
use App\Services\PaymentService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;

class EditRental extends EditRecord
{
    protected static string $resource = RentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label('Ver'),
            Actions\DeleteAction::make(),
            
            // Acción para procesar pago adicional
            Actions\Action::make('processAdditionalPayment')
                ->label('Procesar Pago Adicional')
                ->icon('heroicon-o-credit-card')
                ->color('success')
                ->visible(fn () => $this->record->pending_amount > 0)
                ->form([
                    \Filament\Forms\Components\TextInput::make('pending_amount')
                        ->label('Monto Pendiente')
                        ->prefix('$')
                        ->suffix('DOP')
                        ->disabled()
                        ->default(fn () => number_format($this->record->pending_amount, 2)),
                    
                    \Filament\Forms\Components\Select::make('payment_method')
                        ->label('Método de Pago')
                        ->options([
                            'credit_card' => 'Tarjeta de Crédito',
                            'debit_card' => 'Tarjeta de Débito',
                            'cash' => 'Efectivo',
                            'bank_transfer' => 'Transferencia Bancaria',
                        ])
                        ->required()
                        ->live(),
                    
                    \Filament\Forms\Components\TextInput::make('amount_to_pay')
                        ->label('Monto a Pagar')
                        ->prefix('$')
                        ->suffix('DOP')
                        ->numeric()
                        ->default(fn () => $this->record->pending_amount)
                        ->required()
                        ->rules([
                            'min:0.01',
                            fn () => function (string $attribute, $value, \Closure $fail) {
                                if ($value > $this->record->pending_amount) {
                                    $fail('El monto no puede ser mayor al monto pendiente.');
                                }
                            },
                        ]),
                    
                    \Filament\Forms\Components\Textarea::make('description')
                        ->label('Descripción del Pago')
                        ->default('Pago adicional por extensión del alquiler')
                        ->rows(3),
                    
                    // Campos de tarjeta (visibles solo si se selecciona tarjeta)
                    \Filament\Forms\Components\Section::make('Información de la Tarjeta')
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('card_number')
                                ->label('Número de Tarjeta')
                                ->placeholder('1234 5678 9012 3456')
                                ->mask('9999 9999 9999 9999')
                                ->required()
                                ->rules(['required', 'string', 'min:19', 'max:19']),
                            
                            \Filament\Forms\Components\Grid::make(2)
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('card_expiry')
                                        ->label('Fecha de Expiración')
                                        ->placeholder('MM/YY')
                                        ->mask('99/99')
                                        ->required()
                                        ->rules(['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/']),
                                    
                                    \Filament\Forms\Components\TextInput::make('card_cvv')
                                        ->label('CVV')
                                        ->placeholder('123')
                                        ->mask('999')
                                        ->required()
                                        ->rules(['required', 'string', 'min:3', 'max:3']),
                                ]),
                            
                            \Filament\Forms\Components\TextInput::make('card_name')
                                ->label('Nombre en la Tarjeta')
                                ->placeholder('Juan Pérez')
                                ->required()
                                ->rules(['required', 'string', 'max:255']),
                        ])
                        ->visible(fn (\Filament\Forms\Get $get) => in_array($get('payment_method'), ['credit_card', 'debit_card']))
                        ->collapsed(false),
                ])
                ->action(function (array $data) {
                    $this->processAdditionalPayment($data);
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cargar los datos de la relación payments para mostrar información financiera
        $rental = $this->record->load('payments', 'vehicle');
        
        if ($rental->start_time && $rental->end_time && $rental->vehicle) {
            $start = Carbon::parse($rental->start_time);
            $end = Carbon::parse($rental->end_time);
            $days = max($start->diffInDays($end), 1);
            $totalAmount = $days * $rental->vehicle->price_per_day;
            
            $data['total_amount'] = number_format($totalAmount, 2);
            $data['paid_amount'] = number_format($rental->paid_amount, 2);
            $data['pending_amount'] = number_format($rental->pending_amount, 2);
            $data['additional_amount'] = '0.00'; // Se calculará al cambiar fechas
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Calcular monto adicional solo si se extendió la fecha final
        $originalEndTime = $this->record->end_time;
        $newEndTime = $data['end_time'] ?? null;
        
        if ($originalEndTime && $newEndTime && $this->record->vehicle) {
            $originalEnd = Carbon::parse($originalEndTime);
            $newEnd = Carbon::parse($newEndTime);
            
            // Solo proceder si la nueva fecha es posterior a la original
            if ($newEnd->gt($originalEnd)) {
                $additionalDays = $originalEnd->diffInDays($newEnd);
                $additionalAmount = $additionalDays * $this->record->vehicle->price_per_day;
                
                // Crear pago adicional pendiente
                if ($additionalAmount > 0) {
                    $this->record->createAdditionalPayment(
                        $additionalAmount,
                        $additionalDays,
                        "Extensión del alquiler por {$additionalDays} día(s) adicional(es)"
                    );

                    Notification::make()
                        ->title('Pago adicional creado')
                        ->body("Se creó un pago adicional de $" . number_format($additionalAmount, 2) . " DOP por {$additionalDays} día(s) extra(s).")
                        ->success()
                        ->send();
                }
            }
        }

        return $data;
    }

    protected function processAdditionalPayment(array $data): void
    {
        DB::transaction(function () use ($data) {
            // Buscar el pago pendiente más reciente o crear uno nuevo
            $pendingPayment = $this->record->payments()
                ->where('status', 'pending')
                ->where('payment_type', 'additional')
                ->latest()
                ->first();

            if (!$pendingPayment) {
                // Si no hay pago pendiente, crear uno nuevo
                $pendingPayment = $this->record->createAdditionalPayment(
                    $data['amount_to_pay'],
                    0, // No especificamos días aquí
                    $data['description']
                );
            } else {
                // Actualizar el monto del pago pendiente
                $pendingPayment->update([
                    'amount' => $data['amount_to_pay'],
                    'description' => $data['description'],
                    'payment_method' => $data['payment_method'],
                ]);
            }

            // Procesar el pago según el método seleccionado
            $paymentService = new PaymentService();
            
            if (in_array($data['payment_method'], ['credit_card', 'debit_card'])) {
                // Procesar pago con tarjeta
                $result = $paymentService->processCardPayment($pendingPayment, [
                    'card_number' => $data['card_number'],
                    'card_expiry' => $data['card_expiry'],
                    'card_cvv' => $data['card_cvv'],
                    'card_name' => $data['card_name'],
                ]);
            } else {
                // Procesar pago manual (efectivo/transferencia)
                $result = $paymentService->processCashOrTransferPayment($pendingPayment);
            }

            // Mostrar resultado del pago
            if ($result['success']) {
                Notification::make()
                    ->title('Pago procesado exitosamente')
                    ->body($result['message'] . " - Monto: $" . number_format($data['amount_to_pay'], 2) . " DOP")
                    ->success()
                    ->send();
            } else {
                // Si el pago falló, revertir el estado
                $pendingPayment->update(['status' => 'failed']);
                
                Notification::make()
                    ->title('Error en el pago')
                    ->body($result['message'])
                    ->danger()
                    ->send();
                
                return; // No redirigir si hay error
            }

            // Recargar la página para mostrar cambios
            $this->redirect(static::getUrl('edit', ['record' => $this->record->id]));
        });
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Guardar Cambios'),
            $this->getCancelFormAction()
                ->label('Cancelar'),
        ];
    }
}

<?php

namespace App\Filament\Admin\Resources\RentalResource\Pages;

use App\Filament\Admin\Resources\RentalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewRental extends ViewRecord
{
    protected static string $resource = RentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Editar'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información del Cliente')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Cliente'),
                        Infolists\Components\TextEntry::make('user.profile.first_name')
                            ->label('Nombre'),
                        Infolists\Components\TextEntry::make('user.profile.last_name')
                            ->label('Apellido'),
                        Infolists\Components\TextEntry::make('user.profile.phone')
                            ->label('Teléfono'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Información del Vehículo')
                    ->schema([
                        Infolists\Components\TextEntry::make('vehicle.name')
                            ->label('Vehículo'),
                        Infolists\Components\TextEntry::make('vehicle.make')
                            ->label('Marca'),
                        Infolists\Components\TextEntry::make('vehicle.model')
                            ->label('Modelo'),
                        Infolists\Components\TextEntry::make('vehicle.year')
                            ->label('Año'),
                        Infolists\Components\TextEntry::make('vehicle.category')
                            ->label('Categoría'),
                        Infolists\Components\TextEntry::make('vehicle.transmission')
                            ->label('Transmisión')
                            ->formatStateUsing(fn ($state) => ucfirst($state)),
                        Infolists\Components\TextEntry::make('vehicle.price_per_day')
                            ->label('Precio por Día')
                            ->formatStateUsing(fn ($state) => '$' . number_format($state, 2) . ' DOP'),
                        Infolists\Components\TextEntry::make('vehicle.license_plate')
                            ->label('Placa'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Detalles del Alquiler')
                    ->schema([
                        Infolists\Components\TextEntry::make('pickup_location')
                            ->label('Lugar de Recogida'),
                        Infolists\Components\TextEntry::make('dropoff_location')
                            ->label('Lugar de Devolución'),
                        Infolists\Components\TextEntry::make('start_time')
                            ->label('Fecha de Inicio')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('end_time')
                            ->label('Fecha de Fin')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('duration_days')
                            ->label('Duración')
                            ->formatStateUsing(function ($record) {
                                $days = $record->duration_days;
                                return $days . ' día' . ($days > 1 ? 's' : '');
                            }),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Estado')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'info',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Resumen Financiero')
                    ->schema([
                        Infolists\Components\TextEntry::make('total_amount')
                            ->label('Monto Total')
                            ->formatStateUsing(fn ($record) => $record->formatAmount($record->total_amount))
                            ->color('primary')
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('paid_amount')
                            ->label('Total Pagado')
                            ->formatStateUsing(fn ($record) => $record->formatAmount($record->paid_amount))
                            ->color(fn ($record) => $record->paid_amount > 0 ? 'success' : 'gray')
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('pending_amount')
                            ->label('Monto Pendiente')
                            ->formatStateUsing(fn ($record) => $record->formatAmount($record->pending_amount))
                            ->color(fn ($record) => $record->pending_amount > 0 ? 'warning' : 'success')
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('payment_status')
                            ->label('Estado General de Pagos')
                            ->formatStateUsing(fn ($record) => $record->payment_status)
                            ->badge()
                            ->color(fn ($record) => match($record->payment_status) {
                                'Completamente pagado' => 'success',
                                'Parcialmente pagado' => 'warning',
                                'Sin pagos' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Historial de Pagos')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('payments')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('formatted_description')
                                    ->label('Descripción')
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('formatted_amount')
                                    ->label('Monto')
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('formatted_payment_method')
                                    ->label('Método de Pago'),
                                Infolists\Components\TextEntry::make('formatted_status')
                                    ->label('Estado')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Exitoso' => 'success',
                                        'Pendiente' => 'warning',
                                        'Fallido' => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('additional_days')
                                    ->label('Días Adicionales')
                                    ->visible(fn ($record) => $record->payment_type === 'additional' && $record->additional_days)
                                    ->formatStateUsing(fn ($state) => $state . ' día' . ($state > 1 ? 's' : '')),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Fecha del Pago')
                                    ->dateTime('d/m/Y H:i'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->payments()->count() > 0),

                Infolists\Components\Section::make('Fechas de Registro')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Última Actualización')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
} 
<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RentalResource\Pages;
use App\Models\Rental;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Alquileres';
    protected static ?string $navigationGroup = 'Gestión de Alquileres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->label('Cliente')
                    ->required(),

                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->label('Vehículo')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get, $record) {
                        self::updateAdditionalAmount($set, $get, $record);
                    }),

                Forms\Components\TextInput::make('pickup_location')
                    ->label('Lugar de Recogida')
                    ->required(),

                Forms\Components\TextInput::make('dropoff_location')
                    ->label('Lugar de Devolución')
                    ->required(),

                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get, $record) {
                        self::updateAdditionalAmount($set, $get, $record);
                    }),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Fecha de Fin')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get, $record) {
                        self::updateAdditionalAmount($set, $get, $record);
                    }),

                Forms\Components\Section::make('Información Financiera')
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Monto Total')
                            ->prefix('$')
                            ->suffix('DOP')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (Forms\Get $get) => $get('start_time') && $get('end_time')),

                        Forms\Components\TextInput::make('paid_amount')
                            ->label('Monto Pagado')
                            ->prefix('$')
                            ->suffix('DOP')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('pending_amount')
                            ->label('Monto Pendiente')
                            ->prefix('$')
                            ->suffix('DOP')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('additional_amount')
                            ->label('Monto Adicional (Solo días extras)')
                            ->prefix('$')
                            ->suffix('DOP')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (Forms\Get $get, $record) => $record && $get('start_time') && $get('end_time'))
                            ->helperText('Este monto se calcula solo por los días adicionales agregados'),
                    ])
                    ->columns(2),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmado',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->required()
                    ->label('Estado'),
            ]);
    }

    protected static function updateAdditionalAmount(Forms\Set $set, Forms\Get $get, $record = null): void
    {
        $startTime = $get('start_time');
        $endTime = $get('end_time');
        $vehicleId = $get('vehicle_id');

        if ($startTime && $endTime && $vehicleId) {
            $vehicle = \App\Models\Vehicle::find($vehicleId);
            if ($vehicle) {
                $start = Carbon::parse($startTime);
                $end = Carbon::parse($endTime);
                $newDays = max($start->diffInDays($end), 1);
                $totalAmount = $newDays * $vehicle->price_per_day;
                
                // Establecer el monto total
                $set('total_amount', number_format($totalAmount, 2));

                // Si estamos editando (existe record), calcular monto adicional
                if ($record) {
                    $rental = $record instanceof \App\Models\Rental ? $record : \App\Models\Rental::find($record);
                    if ($rental && $rental->end_time) {
                        $originalEnd = Carbon::parse($rental->end_time);
                        $newEnd = Carbon::parse($endTime);
                        
                        // Solo calcular adicional si la nueva fecha es posterior a la original
                        if ($newEnd->gt($originalEnd)) {
                            $additionalDays = $originalEnd->diffInDays($newEnd);
                            $additionalAmount = $additionalDays * $vehicle->price_per_day;
                            $set('additional_amount', number_format($additionalAmount, 2));
                        } else {
                            $set('additional_amount', '0.00');
                        }
                    }
                }

                // Calcular montos pagado y pendiente
                self::updatePaymentAmounts($set, $record, $totalAmount);
            }
        }
    }

    protected static function updatePaymentAmounts(Forms\Set $set, $record, $totalAmount): void
    {
        if ($record) {
            $rental = $record instanceof \App\Models\Rental ? $record : \App\Models\Rental::find($record);
            if ($rental) {
                $paidAmount = $rental->paid_amount;
                $pendingAmount = max($totalAmount - $paidAmount, 0);
                
                $set('paid_amount', number_format($paidAmount, 2));
                $set('pending_amount', number_format($pendingAmount, 2));
            } else {
                $set('paid_amount', '0.00');
                $set('pending_amount', number_format($totalAmount, 2));
            }
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('vehicle.name')
                    ->label('Vehículo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pickup_location')
                    ->label('Lugar de Recogida')
                    ->sortable()
                    ->limit(30),

                TextColumn::make('dropoff_location')
                    ->label('Lugar de Devolución')
                    ->sortable()
                    ->limit(30),

                TextColumn::make('start_time')
                    ->label('Fecha de Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Fecha de Fin')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label('Duración')
                    ->getStateUsing(function ($record) {
                        $days = $record->duration_days;
                        return $days . ' día' . ($days > 1 ? 's' : '');
                    }),

                TextColumn::make('total_amount')
                    ->label('Monto Total')
                    ->getStateUsing(fn ($record) => $record->formatAmount($record->total_amount))
                    ->sortable(),

                TextColumn::make('paid_amount')
                    ->label('Monto Pagado')
                    ->getStateUsing(fn ($record) => $record->formatAmount($record->paid_amount))
                    ->color(fn ($record) => $record->paid_amount > 0 ? 'success' : 'gray'),

                TextColumn::make('pending_amount')
                    ->label('Monto Pendiente')
                    ->getStateUsing(fn ($record) => $record->formatAmount($record->pending_amount))
                    ->color(fn ($record) => $record->pending_amount > 0 ? 'warning' : 'success'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            default => 'gray',
                        };
                    }),

                TextColumn::make('payment_status')
                    ->label('Estado de Pagos')
                    ->getStateUsing(fn ($record) => $record->payment_status)
                    ->badge()
                    ->color(fn ($record) => match($record->payment_status) {
                        'Completamente pagado' => 'success',
                        'Parcialmente pagado' => 'warning',
                        'Sin pagos' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('payments_count')
                    ->label('Nº Pagos')
                    ->getStateUsing(fn ($record) => $record->payments()->count())
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmado',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Estado de Pagos')
                    ->options([
                        'Completamente pagado' => 'Completamente pagado',
                        'Parcialmente pagado' => 'Parcialmente pagado', 
                        'Sin pagos' => 'Sin pagos',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! $data['value']) {
                            return $query;
                        }

                        return $query->whereHas('payments', function (Builder $query) use ($data) {
                            if ($data['value'] === 'Completamente pagado') {
                                $query->where('status', 'success');
                            } elseif ($data['value'] === 'Parcialmente pagado') {
                                $query->where('status', 'success');
                            } elseif ($data['value'] === 'Sin pagos') {
                                $query->where('status', '!=', 'success');
                            }
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'view' => Pages\ViewRental::route('/{record}'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
} 
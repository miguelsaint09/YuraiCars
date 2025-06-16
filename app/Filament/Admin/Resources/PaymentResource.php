<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Pagos';
    protected static ?string $navigationGroup = 'Gestión de Alquileres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rental_id')
                    ->relationship('rental', 'id')
                    ->label('Alquiler')
                    ->disabled(),

                Forms\Components\TextInput::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->disabled(),

                Forms\Components\Select::make('payment_method')
                    ->options([
                        'credit_card' => 'Tarjeta de Crédito',
                        'debit_card' => 'Tarjeta de Débito',
                        'bank_transfer' => 'Transferencia Bancaria',
                        'cash' => 'Efectivo',
                    ])
                    ->required()
                    ->label('Método de Pago'),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'success' => 'Exitoso',
                        'failed' => 'Fallido',
                        'canceled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                    ])
                    ->required()
                    ->label('Estado'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rental.user.email')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('rental.vehicle.name')
                    ->label('Vehículo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Monto (DOP)')
                    ->money('DOP')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Método de Pago')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'credit_card' => 'Tarjeta de Crédito',
                        'debit_card' => 'Tarjeta de Débito',
                        'bank_transfer' => 'Transferencia Bancaria',
                        'cash' => 'Efectivo',
                        default => ucfirst(str_replace('_', ' ', $state))
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'canceled' => 'gray',
                        'refunded' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'success' => 'Exitoso',
                        'pending' => 'Pendiente',
                        'failed' => 'Fallido',
                        'canceled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                        default => ucfirst($state)
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha de Pago')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'success' => 'Exitoso',
                        'failed' => 'Fallido',
                        'canceled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                    ])
                    ->label('Estado'),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'credit_card' => 'Tarjeta de Crédito',
                        'debit_card' => 'Tarjeta de Débito',
                        'bank_transfer' => 'Transferencia Bancaria',
                        'cash' => 'Efectivo',
                    ])
                    ->label('Método de Pago'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Eliminar Seleccionados'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
} 
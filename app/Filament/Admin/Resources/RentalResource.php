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
                    ->required(),

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
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        self::updateAdditionalAmount($set, $get);
                    }),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Fecha de Fin')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        self::updateAdditionalAmount($set, $get);
                    }),

                Forms\Components\TextInput::make('additional_amount')
                    ->label('Monto Adicional')
                    ->prefix('$')
                    ->suffix('DOP')
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn (Forms\Get $get) => $get('start_time') && $get('end_time')),

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

    protected static function updateAdditionalAmount(Forms\Set $set, Forms\Get $get): void
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
                $set('additional_amount', number_format($totalAmount, 2));
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
                    ->sortable(),

                TextColumn::make('dropoff_location')
                    ->label('Lugar de Devolución')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Fecha de Inicio')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Fecha de Fin')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge(),

                TextColumn::make('payment.amount')
                    ->label('Monto (DOP)')
                    ->sortable(),

                TextColumn::make('payment.payment_method')
                    ->label('Método de Pago')
                    ->sortable(),

                TextColumn::make('payment.status')
                    ->label('Estado del Pago')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
}

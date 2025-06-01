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

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Rentals';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->label('Rented By')
                    ->required(),

                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->label('Vehicle')
                    ->required(),

                Forms\Components\TextInput::make('pickup_location')
                    ->label('Pickup Location')
                    ->required(),

                Forms\Components\TextInput::make('dropoff_location')
                    ->label('Dropoff Location')
                    ->required(),

                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Start Time')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('End Time')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('vehicle.name')
                    ->label('Vehicle')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pickup_location')
                    ->label('Pickup Location')
                    ->sortable(),

                TextColumn::make('dropoff_location')
                    ->label('Dropoff Location')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Start Time')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('End Time')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                // Payment Details (Join with Payment table)
                TextColumn::make('payment.amount')
                    ->label('Amount ($)')
                    ->sortable(),

                TextColumn::make('payment.payment_method')
                    ->label('Payment Method')
                    ->sortable(),

                TextColumn::make('payment.status')
                    ->label('Payment Status')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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

<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Fleet Management';
    protected static ?string $navigationLabel = 'Vehicles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('license_plate')
                    ->label('License Plate')
                    ->required()
                    ->unique(),

                TextInput::make('name')
                    ->required(),

                Select::make('make')
                    ->options([
                        'Toyota' => 'Toyota',
                        'Honda' => 'Honda',
                        'BMW' => 'BMW',
                        'Mercedes' => 'Mercedes',
                        'Ford' => 'Ford',
                        'Tesla' => 'Tesla',
                    ])
                    ->required(),

                TextInput::make('model')
                    ->required(),

                TextInput::make('year')
                    ->type('number')
                    ->required(),

                TextInput::make('color')
                    ->required(),

                Select::make('category')
                    ->options([
                        'Sedan' => 'Sedan',
                        'SUV' => 'SUV',
                        'Hatchback' => 'Hatchback',
                        'Convertible' => 'Convertible',
                        'Truck' => 'Truck',
                        'Van' => 'Van',
                    ])
                    ->required(),

                FileUpload::make('image_url')
                    ->label('Vehicle Image')
                    ->image(),

                TextInput::make('seats')
                    ->type('number')
                    ->required(),

                TextInput::make('luggage_capacity')
                    ->type('number')
                    ->required(),

                Select::make('transmission')
                    ->options([
                        'automatic' => 'Automatic',
                        'manual' => 'Manual',
                    ])
                    ->required(),

                Select::make('fuel_type')
                    ->options([
                        'petrol' => 'Petrol',
                        'diesel' => 'Diesel',
                        'electric' => 'Electric',
                        'hybrid' => 'Hybrid',
                    ])
                    ->required(),

                TextInput::make('price_per_day')
                    ->type('number')
                    ->label('Price Per Day ($)')
                    ->required(),

                TextInput::make('mileage')
                    ->label('Mileage (km)')
                    ->required(),

                TextInput::make('fuel_efficiency')
                    ->label('Fuel Efficiency')
                    ->nullable(),

                Textarea::make('remarks')
                    ->label('Remarks')
                    ->nullable(),

                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'rented' => 'Rented',
                        'maintenance' => 'Maintenance',
                    ])
                    ->required(),

                TextInput::make('features')
                    ->label('Features (Comma-separated)')
                    ->placeholder('GPS, Bluetooth, Backup Camera')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_plate')->sortable()->searchable(),

                TextColumn::make('name')->sortable()->searchable(),

                TextColumn::make('make')->sortable()->searchable(),

                TextColumn::make('model')->sortable(),

                TextColumn::make('year')->sortable(),

                TextColumn::make('price_per_day')->label('Price Per Day ($)')->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'available',
                        'warning' => 'booked',
                        'danger' => 'rented',
                        'gray' => 'maintenance',
                    ]),
                
                TextColumn::make('created_at')
                    ->label('Added On')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'rented' => 'Rented',
                        'maintenance' => 'Maintenance',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}

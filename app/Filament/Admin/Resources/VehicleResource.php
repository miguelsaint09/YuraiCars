<?php

namespace App\Filament\Admin\Resources;

use App\Enums\VehicleFeatures;
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
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Filters\SelectFilter;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Gestión de Flota';
    protected static ?string $navigationLabel = 'Vehículos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Básica')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Vehículo')
                                    ->required()
                                    ->placeholder('Toyota Camry 2024')
                                    ->maxLength(255),

                                TextInput::make('license_plate')
                                    ->label('Matrícula')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Select::make('make')
                                    ->label('Marca')
                                    ->options([
                                        'Toyota' => 'Toyota',
                                        'Honda' => 'Honda',
                                        'BMW' => 'BMW',
                                        'Mercedes' => 'Mercedes',
                                        'Ford' => 'Ford',
                                        'Tesla' => 'Tesla',
                                    ])
                                    ->required()
                                    ->searchable(),

                                TextInput::make('model')
                                    ->label('Modelo')
                                    ->required()
                                    ->placeholder('Camry')
                                    ->maxLength(100),

                                TextInput::make('year')
                                    ->label('Año')
                                    ->numeric()
                                    ->required()
                                    ->minValue(2000)
                                    ->maxValue(date('Y') + 1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                ColorPicker::make('color')
                                    ->label('Color')
                                    ->required(),

                                Select::make('category')
                                    ->label('Categoría')
                                    ->options([
                                        'Sedan' => 'Sedán',
                                        'SUV' => 'SUV',
                                        'Hatchback' => 'Hatchback',
                                        'Convertible' => 'Convertible',
                                        'Truck' => 'Camioneta',
                                        'Van' => 'Van',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('Especificaciones Técnicas')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('seats')
                                    ->label('Asientos')
                                    ->numeric()
                                    ->required()
                                    ->default(5)
                                    ->minValue(2)
                                    ->maxValue(15),

                                Select::make('transmission')
                                    ->label('Transmisión')
                                    ->options([
                                        'automatic' => 'Automática',
                                        'manual' => 'Manual',
                                    ])
                                    ->required()
                                    ->default('automatic'),

                                Select::make('fuel_type')
                                    ->label('Combustible')
                                    ->options([
                                        'petrol' => 'Gasolina',
                                        'diesel' => 'Diesel',
                                        'electric' => 'Eléctrico',
                                        'hybrid' => 'Híbrido',
                                    ])
                                    ->required()
                                    ->default('petrol'),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('luggage_capacity')
                                    ->label('Capacidad de Equipaje (L)')
                                    ->numeric()
                                    ->required()
                                    ->default(100)
                                    ->minValue(0),

                                TextInput::make('mileage')
                                    ->label('Kilometraje')
                                    ->numeric()
                                    ->required()
                                    ->default(0),

                                TextInput::make('fuel_efficiency')
                                    ->label('Eficiencia (km/L)')
                                    ->numeric()
                                    ->nullable(),
                            ]),
                    ]),

                Section::make('Características')
                    ->schema([
                        CheckboxList::make('features')
                            ->label('Características del Vehículo')
                            ->options(VehicleFeatures::class)
                            ->columns(3)
                            ->required(),
                    ]),

                Section::make('Precio y Estado')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('price_per_day')
                                    ->label('Precio por Día (DOP)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->default(50)
                                    ->step(0.01)
                                    ->minValue(0),

                                Select::make('status')
                                    ->label('Estado')
                                    ->options([
                                        'available' => 'Disponible',
                                        'booked' => 'Reservado',
                                        'rented' => 'Alquilado',
                                        'maintenance' => 'En Mantenimiento',
                                    ])
                                    ->required()
                                    ->default('available'),
                            ]),

                        Textarea::make('remarks')
                            ->label('Observaciones')
                            ->placeholder('Información adicional sobre el vehículo')
                            ->rows(3)
                            ->nullable(),
                    ]),

                Section::make('Imágenes')
                    ->schema([
                        FileUpload::make('image_url')
                            ->label('Imágenes del Vehículo')
                            ->multiple()
                            ->maxFiles(5)
                            ->disk('public')
                            ->directory('vehicles')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->helperText('Máximo 5 imágenes (JPG, PNG)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Imagen')
                    ->circular()
                    ->defaultImageUrl(url('/images/sedan.png'))
                    ->size(40),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('license_plate')
                    ->label('Matrícula')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('make')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model')
                    ->label('Modelo')
                    ->searchable(),

                TextColumn::make('year')
                    ->label('Año')
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sedan' => 'success',
                        'SUV' => 'warning',
                        'Hatchback' => 'info',
                        'Convertible' => 'danger',
                        'Truck' => 'gray',
                        'Van' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('price_per_day')
                    ->label('Precio/Día')
                    ->money('DOP')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => 'available',
                        'warning' => 'booked',
                        'danger' => 'rented',
                        'gray' => 'maintenance',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Disponible',
                        'booked' => 'Reservado',
                        'rented' => 'Alquilado',
                        'maintenance' => 'Mantenimiento',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('make')
                    ->label('Marca')
                    ->options([
                        'Toyota' => 'Toyota',
                        'Honda' => 'Honda',
                        'BMW' => 'BMW',
                        'Mercedes' => 'Mercedes',
                        'Ford' => 'Ford',
                        'Tesla' => 'Tesla',
                    ]),

                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'available' => 'Disponible',
                        'booked' => 'Reservado',
                        'rented' => 'Alquilado',
                        'maintenance' => 'En Mantenimiento',
                    ]),

                SelectFilter::make('category')
                    ->label('Categoría')
                    ->options([
                        'Sedan' => 'Sedán',
                        'SUV' => 'SUV',
                        'Hatchback' => 'Hatchback',
                        'Convertible' => 'Convertible',
                        'Truck' => 'Camioneta',
                        'Van' => 'Van',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

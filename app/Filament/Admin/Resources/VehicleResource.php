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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Toggle;
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
                Tabs::make('Vehicle Information')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('license_plate')
                                                    ->label('License Plate')
                                                    ->required()
                                                    ->validationMessages([
                                                        'required' => 'La placa es requerida',
                                                        'unique' => 'Esta placa ya está registrada'
                                                    ])
                                                    ->unique('vehicles', ignoreRecord: true)
                                                    ->placeholder('ABC-123')
                                                    ->helperText('Enter the vehicle\'s license plate number')
                                                    ->columnSpan(1),

                                                TextInput::make('name')
                                                    ->required(fn(): string => 'El nombre es requerido')
                                                    ->placeholder('Toyota Camry LE')
                                                    ->helperText('Enter a descriptive name for the vehicle')
                                                    ->columnSpan(2),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Select::make('make')
                                                    ->options([
                                                        'Toyota' => 'Toyota',
                                                        'Honda' => 'Honda',
                                                        'BMW' => 'BMW',
                                                        'Mercedes' => 'Mercedes',
                                                        'Ford' => 'Ford',
                                                        'Tesla' => 'Tesla',
                                                    ])
                                                    ->required(fn(): string => 'La marca es requerida')
                                                    ->searchable()
                                                    ->preload(),

                                                TextInput::make('model')
                                                    ->required(fn(): string => 'El modelo es requerido')
                                                    ->placeholder('Camry'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('year')
                                                    ->type('number')
                                                    ->required(fn(): string => 'El año es requerido')
                                                    ->default(date('Y'))
                                                    ->rules(['min:2000', 'max:' . (date('Y') + 1)])
                                                    ->numeric(),

                                                ColorPicker::make('color')
                                                    ->required()
                                                    ->validationMessages([
                                                        'required' => 'El color es requerido'
                                                    ])
                                                    ->label('Color del Vehículo')
                                                    ->hex(),

                                                Select::make('category')
                                                    ->options([
                                                        'Sedan' => 'Sedan',
                                                        'SUV' => 'SUV',
                                                        'Hatchback' => 'Hatchback',
                                                        'Convertible' => 'Convertible',
                                                        'Truck' => 'Truck',
                                                        'Van' => 'Van',
                                                    ])
                                                    ->required(fn(): string => 'La categoría es requerida')
                                                    ->searchable()
                                                    ->preload(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Specifications')
                            ->icon('heroicon-m-cog')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('seats')
                                                    ->integer()
                                                    ->required(fn(): string => 'El número de asientos es requerido')
                                                    ->default(5)
                                                    ->minValue(2)
                                                    ->maxValue(15)
                                                    ->suffix('seats')
                                                    ->helperText('Number of passenger seats'),

                                                TextInput::make('luggage_capacity')
                                                    ->type('number')
                                                    ->required(fn(): string => 'La capacidad de equipaje es requerida')
                                                    ->default(100)
                                                    ->minValue(0)
                                                    ->suffix('L')
                                                    ->helperText('Luggage capacity in liters'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Select::make('transmission')
                                                    ->options([
                                                        'automatic' => 'Automatic',
                                                        'manual' => 'Manual',
                                                    ])
                                                    ->required(fn(): string => 'El tipo de transmisión es requerido')
                                                    ->default('automatic'),

                                                Select::make('fuel_type')
                                                    ->options([
                                                        'petrol' => 'Petrol',
                                                        'diesel' => 'Diesel',
                                                        'electric' => 'Electric',
                                                        'hybrid' => 'Hybrid',
                                                    ])
                                                    ->required(fn(): string => 'El tipo de combustible es requerido')
                                                    ->default('petrol'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('mileage')
                                                    ->label('Current Mileage')
                                                    ->required(fn(): string => 'El kilometraje es requerido')
                                                    ->suffix('km')
                                                    ->numeric()
                                                    ->default(0),

                                                TextInput::make('fuel_efficiency')
                                                    ->label('Fuel Efficiency')
                                                    ->suffix('km/L')
                                                    ->numeric()
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Features & Images')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Section::make('Vehicle Features')
                                    ->schema([
                                        CheckboxList::make('features')
                                            ->options(VehicleFeatures::class)
                                            ->columns(3)
                                            ->gridDirection('row')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Debe seleccionar al menos una característica'
                                            ])
                                            ->helperText('Select all the features available in this vehicle'),
                                    ]),

                                Section::make('Vehicle Images')
                                    ->schema([
                                        FileUpload::make('image_url')
                                            ->label('Imágenes del Vehículo')
                                            ->multiple()
                                            ->maxFiles(5)
                                            ->disk('public')
                                            ->directory('vehicles')
                                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                                            ->rules(['mimes:jpg,jpeg,png'])
                                            ->validationMessages([
                                                'mimes' => 'Solo se permiten imágenes en formato JPG o PNG'
                                            ])
                                            ->helperText('Suba hasta 5 imágenes del vehículo (formatos permitidos: JPG, PNG)'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Pricing & Status')
                            ->icon('heroicon-m-currency-dollar')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('price_per_day')
                                                    ->type('number')
                                                    ->required(fn(): string => 'El precio por día es requerido')
                                                    ->prefix('$')
                                                    ->numeric()
                                                    ->default(50)
                                                    ->step(0.01)
                                                    ->minValue(0)
                                                    ->helperText('Daily rental rate in dollars'),

                                                Select::make('status')
                                                    ->options([
                                                        'available' => 'Available',
                                                        'booked' => 'Booked',
                                                        'rented' => 'Rented',
                                                        'maintenance' => 'Maintenance',
                                                    ])
                                                    ->required(fn(): string => 'El estado es requerido')
                                                    ->default('available'),
                                            ]),

                                        Textarea::make('remarks')
                                            ->label('Additional Remarks')
                                            ->placeholder('Enter any additional information about the vehicle')
                                            ->rows(3)
                                            ->nullable(),
                                    ]),
                            ]),
                    ])
                    ->columnSpan('full'),
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
                TextColumn::make('price_per_day')
                    ->label('Price Per Day ($)')
                    ->sortable()
                    ->money('USD'),
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

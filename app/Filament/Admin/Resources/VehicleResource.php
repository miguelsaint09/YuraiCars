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
                Tabs::make('Vehículo')
                    ->tabs([
                        Tabs\Tab::make('Información Básica')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nombre del Vehículo')
                                                    ->required(fn(): string => 'El nombre es requerido')
                                                    ->placeholder('Toyota Camry 2024')
                                                    ->helperText('Ingrese un nombre descriptivo para el vehículo')
                                                    ->columnSpan(2),
                                            ]),

                                        Grid::make(2)
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
                                                    ->required(fn(): string => 'La marca es requerida')
                                                    ->searchable()
                                                    ->preload(),

                                                TextInput::make('model')
                                                    ->label('Modelo')
                                                    ->required(fn(): string => 'El modelo es requerido')
                                                    ->placeholder('Camry'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('year')
                                                    ->label('Año')
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

                                                TextInput::make('license_plate')
                                                    ->label('Matrícula')
                                                    ->required(fn(): string => 'La matrícula es requerida')
                                                    ->unique(ignoreRecord: true),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
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
                                                    ->required(fn(): string => 'La categoría es requerida')
                                                    ->searchable()
                                                    ->preload(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Especificaciones')
                            ->icon('heroicon-m-cog')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('seats')
                                                    ->label('Asientos')
                                                    ->integer()
                                                    ->required(fn(): string => 'El número de asientos es requerido')
                                                    ->default(5)
                                                    ->minValue(2)
                                                    ->maxValue(15)
                                                    ->suffix('asientos')
                                                    ->helperText('Número de asientos para pasajeros'),

                                                TextInput::make('luggage_capacity')
                                                    ->label('Capacidad de Equipaje')
                                                    ->type('number')
                                                    ->required(fn(): string => 'La capacidad de equipaje es requerida')
                                                    ->default(100)
                                                    ->minValue(0)
                                                    ->suffix('L')
                                                    ->helperText('Capacidad de equipaje en litros'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Select::make('transmission')
                                                    ->label('Transmisión')
                                                    ->options([
                                                        'automatic' => 'Automática',
                                                        'manual' => 'Manual',
                                                    ])
                                                    ->required(fn(): string => 'El tipo de transmisión es requerido')
                                                    ->default('automatic'),

                                                Select::make('fuel_type')
                                                    ->label('Tipo de Combustible')
                                                    ->options([
                                                        'petrol' => 'Gasolina',
                                                        'diesel' => 'Diesel',
                                                        'electric' => 'Eléctrico',
                                                        'hybrid' => 'Híbrido',
                                                    ])
                                                    ->required(fn(): string => 'El tipo de combustible es requerido')
                                                    ->default('petrol'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('mileage')
                                                    ->label('Kilometraje')
                                                    ->required()
                                                    ->suffix('km')
                                                    ->numeric()
                                                    ->default(0),

                                                TextInput::make('fuel_efficiency')
                                                    ->label('Eficiencia de Combustible')
                                                    ->suffix('km/L')
                                                    ->numeric()
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Características e Imágenes')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Section::make('Características del Vehículo')
                                    ->schema([
                                        CheckboxList::make('features')
                                            ->label('Características')
                                            ->options(VehicleFeatures::class)
                                            ->columns(3)
                                            ->gridDirection('row')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Debe seleccionar al menos una característica'
                                            ])
                                            ->helperText('Seleccione todas las características disponibles en este vehículo'),
                                    ]),

                                Section::make('Imágenes del Vehículo')
                                    ->schema([
                                        FileUpload::make('image_url')
                                            ->label('Imágenes')
                                            ->multiple()
                                            ->maxFiles(5)
                                            ->disk('public')
                                            ->directory('vehicles')
                                            ->visibility('public')
                                            ->preserveFilenames()
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(5120)
                                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                                            ->rules(['mimes:jpg,jpeg,png'])
                                            ->validationMessages([
                                                'mimes' => 'Solo se permiten imágenes en formato JPG o PNG'
                                            ])
                                            ->helperText('Suba hasta 5 imágenes del vehículo (formatos permitidos: JPG, PNG)'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Precio y Estado')
                            ->icon('heroicon-m-currency-dollar')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('price_per_day')
                                                    ->label('Precio por Día')
                                                    ->type('number')
                                                    ->required(fn(): string => 'El precio por día es requerido')
                                                    ->prefix('$')
                                                    ->numeric()
                                                    ->default(50)
                                                    ->step(0.01)
                                                    ->minValue(0)
                                                    ->helperText('Tarifa diaria de alquiler en pesos dominicanos'),

                                                Select::make('status')
                                                    ->label('Estado')
                                                    ->options([
                                                        'available' => 'Disponible',
                                                        'booked' => 'Reservado',
                                                        'rented' => 'Alquilado',
                                                        'maintenance' => 'En Mantenimiento',
                                                    ])
                                                    ->required(fn(): string => 'El estado es requerido')
                                                    ->default('available'),
                                            ]),

                                        Textarea::make('remarks')
                                            ->label('Observaciones Adicionales')
                                            ->placeholder('Ingrese cualquier información adicional sobre el vehículo')
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
                TextColumn::make('name')->sortable()->searchable()->label('Nombre'),
                TextColumn::make('make')->sortable()->searchable()->label('Marca'),
                TextColumn::make('model')->sortable()->label('Modelo'),
                TextColumn::make('year')->sortable()->label('Año'),
                TextColumn::make('price_per_day')
                    ->label('Precio por Día (DOP)')
                    ->sortable()
                    ->money('DOP'),
                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => 'available',
                        'warning' => 'booked',
                        'danger' => 'rented',
                        'gray' => 'maintenance',
                    ]),
                TextColumn::make('created_at')
                    ->label('Agregado el')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Disponible',
                        'booked' => 'Reservado',
                        'rented' => 'Alquilado',
                        'maintenance' => 'En Mantenimiento',
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

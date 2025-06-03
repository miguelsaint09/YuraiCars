<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\UserProfile;
use App\Enums\UserStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $slug = 'users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['profile']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('User Management')
                    ->tabs([
                        Tabs\Tab::make('Account Information')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Email'),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->required()
                    ->label('Role'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('password')
                                                    ->password()
                                                    ->required(fn ($context) => $context === 'create')
                                                    ->minLength(8)
                                                    ->label('Password')
                                                    ->dehydrated(fn ($state) => filled($state))
                                                    ->same('password_confirmation'),
                                                TextInput::make('password_confirmation')
                                                    ->password()
                                                    ->required(fn ($context) => $context === 'create')
                                                    ->minLength(8)
                                                    ->label('Confirm Password')
                                                    ->dehydrated(false),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                Toggle::make('status')
                    ->label('Active')
                                                    ->default(true)
                                                    ->inline(false)
                                                    ->formatStateUsing(fn ($state) => $state === UserStatus::ACTIVE->value)
                                                    ->dehydrateStateUsing(fn ($state) => $state ? UserStatus::ACTIVE->value : UserStatus::INACTIVE->value),
                                                DateTimePicker::make('email_verified_at')
                                                    ->label('Email Verified At')
                                                    ->disabled(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Personal Information')
                            ->icon('heroicon-m-identification')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('profile.first_name')
                                                    ->maxLength(255)
                                                    ->label('First Name'),
                                                TextInput::make('profile.last_name')
                                                    ->maxLength(255)
                                                    ->label('Last Name'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('profile.phone')
                                                    ->tel()
                                                    ->label('Phone Number'),
                                                TextInput::make('profile.license_number')
                                                    ->label('License Number'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                DatePicker::make('profile.date_of_birth')
                                                    ->label('Date of Birth')
                                                    ->displayFormat('M d, Y'),
                DateTimePicker::make('created_at')
                                                    ->label('Registered At')
                                                    ->disabled(),
                                            ]),
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
                TextColumn::make('profile.first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('profile.last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('profile.phone')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('profile.license_number')
                    ->label('License')
                    ->searchable(),
                BadgeColumn::make('role')
                    ->colors([
                        'primary' => 'admin',
                        'success' => 'user',
                    ]),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->formatStateUsing(fn ($state) => $state),
                TextColumn::make('created_at')
                    ->label('Registered At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->label('Role'),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->label('Status'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['profile'])) {
            foreach ($data['profile'] as $key => $value) {
                $data['profile.' . $key] = $value;
            }
        }
        return $data;
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $profileData = $data['profile'] ?? [];
        
        $user = User::create([
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
            'password' => bcrypt($data['password']),
        ]);

        $user->profile()->create($profileData);

        return $data;
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record && isset($data['role'])) {
            // Verificar si el usuario autenticado está intentando modificar su propio rol
            if (auth()->id() === $this->record->id) {
                throw new \Exception('You cannot modify your own role.');
            }

            $this->record->profile()->updateOrCreate(
                ['user_id' => $this->record->id],
                $data['profile']
            );
        }

        unset($data['profile']);
        return $data;
    }
}

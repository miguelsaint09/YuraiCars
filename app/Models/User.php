<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasName, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'role',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Filament
     */
    public function getFilamentName(): string
    {
        if ($this->profile && $this->profile->first_name) {
            return $this->profile->first_name . ' ' . ($this->profile->last_name ?? '');
        }
        return $this->getAttributeValue('email');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's full name from their profile.
     */
    public function getFullNameAttribute(): string
    {
        if ($this->profile && $this->profile->first_name) {
            return trim($this->profile->first_name . ' ' . ($this->profile->last_name ?? ''));
        }
        return $this->email;
    }

    /**
     * Get the user's first name from their profile.
     */
    public function getFirstNameAttribute(): ?string
    {
        return $this->profile?->first_name;
    }

    // relations
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $authUser, User $user)
    {
        // Permitir solo si el usuario autenticado es admin o el mismo usuario
        return $authUser->role === 'admin' || $authUser->id === $user->id;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'license_number' => 'string',
        'date_of_birth' => 'date',
        'is_completed' => 'boolean',
    ];

    // Attribute mutators to ensure string fields are never null
    protected function getFirstNameAttribute($value): string
    {
        return $value ?? '';
    }

    protected function getLastNameAttribute($value): string
    {
        return $value ?? '';
    }

    protected function getPhoneAttribute($value): string
    {
        return $value ?? '';
    }

    protected function getLicenseNumberAttribute($value): string
    {
        return $value ?? '';
    }

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

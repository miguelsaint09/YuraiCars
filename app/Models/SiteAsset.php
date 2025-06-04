<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteAsset extends Model
{
    protected $fillable = [
        'key',
        'name', 
        'url',
        'alt_text',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public static function getByKey(string $key): ?self
    {
        return self::where('key', $key)->where('is_active', true)->first();
    }

    public static function getUrlByKey(string $key): ?string
    {
        $asset = self::getByKey($key);
        return $asset ? $asset->url : null;
    }
}

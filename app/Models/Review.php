<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    use HasUuids;
    
    protected $fillable = ['user_id', 'vehicle_id', 'rating', 'comment'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
} 
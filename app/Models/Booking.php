<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'carebuddy_id',
        'parent_id',
        'status',
        'amount',
        'paid_at',
    ];

    public function carebuddy()
    {
        return $this->belongsTo(CareBuddy::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Parent::class, 'parent_id');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $casts = [
        'paid_at' => 'datetime',
    ];
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
        return $this->belongsTo(\App\Models\Parents::class, 'parent_id');
    }
}

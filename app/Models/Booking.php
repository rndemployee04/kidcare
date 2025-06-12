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
        'carebuddy_accepted',
        'platform_fee',
        'carebuddy_earnings',
        'accepted_at',
        'duration',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'accepted_at' => 'datetime',
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

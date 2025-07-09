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
        'playpal_id'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function carebuddy()
    {
        return $this->belongsTo(CareBuddy::class, 'carebuddy_id');
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function playPal()
    {
        return $this->belongsTo(PlayPal::class, 'playpal_id');
    }
    
}

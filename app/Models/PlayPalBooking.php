<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayPalBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'playpal_id', 'parent_id', 'child_id', 'date', 'time', 'duration_days', 'amount', 'status',
    ];

    public function playpal()
    {
        return $this->belongsTo(PlayPal::class, 'playpal_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'account_holder',
        'account_number',
        'ifsc',
        'bank_name',
        'status',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentProfile::class);
    }
    
}

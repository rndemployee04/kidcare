<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'account_holder',
        'account_number',
        'ifsc',
        'bank_name',
        'is_default',
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }
}

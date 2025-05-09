<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'phone',
        'dob',
        'gender',
        'profile_photo',
        'id_proof_path',
        'permanent_address',
        'current_address',
        'city',
        'state',
        'zip',
        'profession',
        'spouse_name',
        'spouse_email',
        'spouse_phone',
        'spouse_profession',
        'monthly_income',
        'number_of_children',
        'number_needing_care',
        'preferred_drop_off_time',
        'preferred_type_of_caregiver',
        'preferred_radius',
        'needs_special_needs_support',
        'reason_for_service',
        'emergency_contact_name',
        'emergency_contact_phone',
        'terms_accepted',
    ];

    protected $casts = [
        'children_ages' => 'array',
        'needs_special_needs_support' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }
}

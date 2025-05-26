<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareBuddy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'id_proof_path',
        'selfie_path',
        'dob',
        'phone',
        'gender',
        'profile_photo',
        'permanent_address',
        'current_address',
        'city',
        'state',
        'zip',
        'service_radius',
        'child_age_limit',
        'willing_to_take_insurance',
        'background_check_consent',
        'terms_accepted',
        'availability',
        'certificate_path',
        'marriage_certificate_path',
        'birth_certificate_path',
        'child_birth_certificate_path',
    ];


    protected $casts = [
        'dob' => 'date',
        'availability' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

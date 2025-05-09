<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'full_name',
        'dob',
        'gender',
        'photo',
        'birth_certificate_path',
        'id_proof_path',
        'has_insurance',
        'insurance_company',
        'insurance_terms',
        'diseases',
        'disabilities',
        'allergies',
        'hobbies',
    ];

    protected $casts = [
        'dob' => 'date',
        'has_insurance' => 'boolean',
        'diseases' => 'array',
        'disabilities' => 'array',
        'allergies' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }
}

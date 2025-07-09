<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'verification_status',
        'registration_complete',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function isCareBuddy(): bool
    {
        return $this->role === 'carebuddy';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Relationship: CareBuddy profile
     */
    public function careBuddy()
    {
        return $this->hasOne(CareBuddy::class);
    }

    /**
     * Relationship: Parent profile
     */
    public function parentProfile()
    {
        return $this->hasOne(Parents::class, 'user_id');
    }

    public function playPal()
    {
        return $this->hasOne(PlayPal::class);
    }

    public function isPlayPal(): bool
    {
        return $this->role === 'playpal';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function isRegistrationComplete(): bool
    {
        return $this->registration_complete;
    }

}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role', 'phone', 'street', 'city', 'country'
    ];

// Klient má predpis
    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class, 'customer_id');
    }

// Klient má košík
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

// Klient má objednávky
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

// Klient má rezervácie
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

// Optometrista má rezervácie
    public function optometristAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'optometrist_id');
    }

// Pomocné metódy pre roly
    public function isOptometrist(): bool  { return $this->role === 'optometrist'; }
    public function isTechnician(): bool   { return $this->role === 'technician'; }
    public function isCustomer(): bool     { return $this->role === 'customer'; }
    public function isManager(): bool      { return $this->role === 'manager'; }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

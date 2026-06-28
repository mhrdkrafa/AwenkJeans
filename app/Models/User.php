<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isKaryawan()
    {
        return $this->role && $this->role->name === 'karyawan';
    }

    public function isAdministrator()
    {
        return $this->role && $this->role->name === 'administrator';
    }

    public function isOwner()
    {
        return $this->role && $this->role->name === 'owner';
    }

    public function isKasir()
    {
        return $this->role && $this->role->name === 'kasir';
    }

    public function isPelanggan()
    {
        return $this->role && $this->role->name === 'pelanggan';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get transactions where this user was the customer (pelanggan_id).
     */
    public function purchasedTransactions()
    {
        return $this->hasMany(Transaction::class, 'pelanggan_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

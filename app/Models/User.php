<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'role', 'user_meta_id'];


    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userMeta()
    {
        return $this->belongsTo(UserMeta::class);
    }

    public function installations()
    {
        return $this->hasOne(Installation::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enum\Roles;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'patronymic', 'last_name_print', 'address', 'position'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    public function holidays()
    {
        return $this->hasMany(\App\Models\Holiday::class);
    }

    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }

    public function password_reset() {
        return $this->hasOne(\App\Models\Password_reset::class, 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_blocked', false);
    }
}

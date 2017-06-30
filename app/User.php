<?php

namespace App;

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
        'first_name', 'last_name', 'patronymic', 'last_name_print', 'address', 
        'comment', 'email', 'password', 'position_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function holiday()
    {
        return $this->hasMany(\App\Models\Holiday::class);
    }
    
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }
    
    /*public function scopeActive($query) 
    {
        return $query->where->('is_block', 1);
    }*/
}

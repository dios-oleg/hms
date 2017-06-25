<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'comment', 'email', 'password', 'position_id', 'head',
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
        return $this->hasMany('App\Holiday');
    }
    
    public function position()
    {
        return $this->belongsTo('App\Position');
    }
    
    public function setHead() {
        $this->head = true;
        $this->save();
    }
    
    public function unsetHead() {
        $this->head = false;
        $this->save();
    }
    
    public function setBlock($comment = null) {
        $this->blocked = true;
        $this->comment = $comment; // TODO or delete because is fillable
        $this->save();
    }
    
    public function unsetBlock() {
        $this->blocked = false;
        $this->comment = null;
        $this->save();
    }
}

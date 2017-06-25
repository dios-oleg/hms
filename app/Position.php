<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    
    protected $fillable =  ['name', 'name_print', 'priority'];
    
    public function user()
    {
        return $this->hasMany('App\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['token'];
    
    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}

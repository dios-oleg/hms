<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
    public $timestamps = false;

    protected $fillable = ['token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    /*public function getCreatedAtAttribute($date)
    {
        return (new Carbon($date))->formatLocalized('%d.%m.%Y в %H:%M:%S');
    }*/
}

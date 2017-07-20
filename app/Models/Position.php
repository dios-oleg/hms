<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = false;

    protected $fillable =  ['name', 'name_print', 'priority'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

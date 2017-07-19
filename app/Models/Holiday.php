<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function statuses() {
        return $this->hasMany('App\StatusHoliday');
    }

}

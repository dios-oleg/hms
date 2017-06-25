<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusHoliday extends Model
{
    public function holiday() {
        return $this->belongsTo('App\Holiday');
    }
    
    public function head() {
        return $this->belongsTo('App\User', 'head_id');
    }
}

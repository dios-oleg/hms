<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['start_date', 'end_date', 'comment'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statuses() {
        return $this->hasMany(StatusHoliday::class);
    }

}

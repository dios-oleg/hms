<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHoliday extends Model
{
    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }

    public function leader()
    {
        return $this->belongsTo(Holiday::class);
    }
}

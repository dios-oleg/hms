<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SystemParameter extends Model
{
    public $timestamps = false;

    public function getRouteKeyName()
    {
      return 'key';
    }

    public function getCreatedAtAttribute($date)
    {
        return (new Carbon($date))->formatLocalized('%d.%m.%Y в %H:%M:%S');
    }

}

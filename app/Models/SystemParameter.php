<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemParameter extends Model
{
    public $timestamps = false;

    public function getRouteKeyName()
    {
      return 'key';
    }

}

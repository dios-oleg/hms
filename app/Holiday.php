<?php

namespace App;

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
    
    public function status() {
        // вернуть последний действительный статус в модели - это использовать статусес и вернуть последний или отсортировать и вернуть последний
        return $this->statuses()->orderBy('created_at', 'desc')->first(); // TODO вроде бы есть метод, которые сразу наоборот сортирует
    }
    
    public function () {
        
    }
}

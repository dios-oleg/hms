<?php
namespace App\Enum;

abstract class AbstractEnum 
{
    
   static function getConstants() {
        $rc = new \ReflectionClass(get_called_class());
        return $rc->getConstants();
    }
    
}

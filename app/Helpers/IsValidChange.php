<?php

namespace App\Helpers;

class IsValidChange{
    public static function compare($a, $b)
    {
        if( $a != null && $a != $b ){
            return true;
        }

        return false;
    }
}
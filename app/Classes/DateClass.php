<?php

/**
 * Creating user classes for Laravel
 * 
 * Create a new directory 'Classes' in the App directory.
 * Save your user classes to the 'Classes' directory.
 * Add  the App/Classes to the composer.json 'autoload' (see below).
 * 
 * To activate this remember to dump the autoloader: $ composer dump-autoload
 */

/*
File: composer.json

"autoload": {
    "classmap": [
        "app/Classes"
    ]
}

*/

namespace App\Classes;

class DateClass
{
    private $now;
    
    public function __construct()
    {
        $this->now = date('Y-m-d');
    }
    
    public function AddDays($days, $date = NULL)
    {
        $date = !$date ? $this->now : $date;
        
        return date('Y-m-d', strtotime($date. " + $days days") );
    }
    
    public function SubDays($days, $date = NULL)
    {
        $date = !$date ? $this->now : $date;
        
        return date('Y-m-d', strtotime($date. " - $days days") );
    }
}
<?php

/**
 * Creating user functions for Laravel
 * 
 * Create a new 'helpers_user.php' file in the App directory.
 * Add 'helpers_user.php' to the composer.json 'autoload' (see below).
 * 
 * To activate this remember to dump the autoloader: $ composer dump-autoload
 */

/*

"autoload": {
    "files": [
        "app/helpers_user.php"
    ]
}

*/

// https://laravel-news.com/creating-helpers

if (! function_exists('css_dropdown_fnc')) {
    /**
     * A CSS dropdown that avoids using the <select> tag.
     * The design is taken from https://www.w3schools.com/Css/css_dropdowns.asp
     * Uses the css dropdown CSS styling (public/style.css)
     * 
     * @param  var                $dd_select        Current dropdown option that gets displayed.
     * @param  array              $dd_array         Dropdown options to diplay when clicked.
     * @param  boolean [optional] $use_array_keys   True results in the array's keys/values being used for dropdown options' values/text.
     *                                              False uses the array's values for both. The default is both (False).
     * @return string                               Returns the dropdown HTML.
     */
    function css_dropdown_fnc($dd_select, $dd_array, $use_array_keys=False)
    {
        $array = [];
        $array[] = '<li class="dropdown">';
        $array[] = '<a href="javascript:void(0)" class="dropbtn">'.$dd_select.' &#9662;</a>';
        $array[] = '<div class="dropdown-content">';
        foreach ($dd_array as $key => $txt) {
            $val = $use_array_keys ? $key : $txt;
            // $array[] = '<a href="http://127.0.0.1:8000/sellers/'.$val.'">'.$txt.'&nbsp;&nbsp;</a>';
            $array[] = '<a href="' .url("sellers/$val"). '">' .$txt.'&nbsp;&nbsp;</a>';
        }
        $array[] = '</div></li>';
        
        return implode('', $array);
    }
}

if (! function_exists('date_fmt_fnc')) {
    function date_fmt_fnc($date, $fmt)
    {
        if( false !== stripos($date, '-') ){
            list($d,$m,$y) = explode('-', $date);
            
            if ('dd-mm-yyyy' == $fmt) { return "$d-$m-$y"; }
            elseif ('yyyy-mm-dd' == $fmt) { return "$y-$m-$d"; }
        }
        else { return $date; }
    }
}

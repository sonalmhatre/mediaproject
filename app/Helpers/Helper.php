<?php

namespace App\Helpers; 

use App\Models\Job;
use App\Models\HighlightJob;
use App\Models\Event;
use App\Models\HighlightEvent;
use App\Models\Company;
use App\Models\HighlightCompany;
// use App\Models\Video;
// use App\Models\HighlightEvent;
class Helper {

      // public function __construct(){
        
      // }

    public static function ratio($a, $b)
    {
        $gcd = function($a, $b) use (&$gcd) {
            return ($a % $b) ? $gcd($b, $a % $b) : $b;
        };
        $g = $gcd($a, $b);
        return $a/$g . ':' . $b/$g;
    }

}


<?php

namespace App\Utils;

use Carbon\Carbon;

class Date
{

    use ResolveClass;

    public function dateNow(): Carbon {
        return Carbon::now();
    }










}

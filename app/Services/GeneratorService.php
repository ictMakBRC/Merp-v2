<?php

namespace App\Services;

use Illuminate\Support\Str;

class GeneratorService
{
    public static function password()
    {
        return Str::password(8);
    }


}

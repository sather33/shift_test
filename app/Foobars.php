<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Foobars extends Model
{
    public function name(Request $request)
    {
        $name = ['1', '2', '3'];
        return 'laravel';
    }
}

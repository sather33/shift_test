<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiDocController extends Controller
{
    public function __invoke()
    {
        return view('api-doc.index');
    }
}

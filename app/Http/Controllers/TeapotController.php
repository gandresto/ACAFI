<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeapotController extends Controller
{
    public function brew(Request $request)
    {
        return abort(418, "I'm a teapot");
    }
}

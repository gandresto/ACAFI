<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeapotController extends Controller
{
    public function brew(Request $request)
    {
        return view('errors.418', ['errors' => [
            [
                'code' => '418',
                'message' => 'I\'m a teapot'
            ]
        ]]);
    }
}

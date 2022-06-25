<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validateUser(Request $request)
    {
        return response()->json($request->user());
    }
}

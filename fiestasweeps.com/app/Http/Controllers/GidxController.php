<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        return response()->json([
            'location' => $req->location,
            'ip' => $req->ip()
        ]);
    }
}

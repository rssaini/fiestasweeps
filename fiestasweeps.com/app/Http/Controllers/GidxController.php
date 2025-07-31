<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\GidxCustomerIdentityService;
use Illuminate\Support\Str;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $gidx = new GidxCustomerIdentityService();
        $location = json_decode($req->location, true);
        dd($gidx->customerRegistration([
            'merchant_customer_id' => 'CUST-0002',
            'first_name' => 'Rahul',
            'last_name' => 'Saini',
            'date_of_birth' => '05/26/1992',
            'email_address' => 'rssaini.26@gmail.com',
            'mobile_phone_number' => '(999) 689-9025',
            'merchant_session_id' => (string) Str::uuid(),
            'ip' => $req->ip(),
            'latitude' => $location['coords']['latitude'],
            'longitude' => $location['coords']['longitude'],
            'radius' => $location['coords']['accuracy'],
            'altitude' => $location['coords']['altitude'],
            'speed' => $location['coords']['speed'],
            'datetime' => $location['timestamp'],
        ]));
        return response()->json([
            'location' => $req->location,
            'ip' => $req->ip()
        ]);
    }
}

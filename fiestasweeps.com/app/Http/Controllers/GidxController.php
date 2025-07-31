<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\GidxCustomerIdentityService;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $gidx = new GidxCustomerIdentityService();
        $location = json_decode($req->location, true);
        dd($gidx->customerRegistration([
            'merchant_customer_id' => '',
            'first_name' => 'Rahul',
            'last_name' => 'Saini',
            'date_of_birth' => '26/05/1992',
            'email_address' => '26/05/1992',
            'citizenship_country_code' => '26/05/1992',
            'identification_type_code' => '26/05/1992',
            'identification_number' => '26/05/1992',
            'mobile_phone_number' => '26/05/1992',
            'merchant_session_id' => '',
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

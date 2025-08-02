<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\GidxCustomerIdentityService;
use Illuminate\Support\Str;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $user = auth()->user();
        $gidx = new GidxCustomerIdentityService();
        $location = json_decode($req->location, true);

        /*
        $session = $gidx->createSession([
            'merchant_session_id' => (string) Str::uuid(),
            'customer_id' => 'CUST-' . Str::padLeft($user->id, 4, '0'),
            'ip' => $req->ip()
        ]);
        return response()->json(["response" => $session, "url" => urldecode($session['SessionURL'])]);
        */

        dd($gidx->customerRegistration([
            'merchant_customer_id' => 'CUST-' . Str::padLeft($user->id, 4, '0'),
            'first_name' => $user->name,
            'last_name' => $user->lname,
            'date_of_birth' => $user->dob,
            'email_address' => $user->email,
            'mobile_phone_number' => $user->phone,
            'merchant_session_id' => (string) Str::uuid(),
            'ip' => $req->ip(),
            'latitude' => $location['coords']['latitude'],
            'longitude' => $location['coords']['longitude'],
            'radius' => $location['coords']['accuracy'],
            'altitude' => $location['coords']['altitude'],
            'speed' => $location['coords']['speed'],
            'datetime' => $location['timestamp'],
        ]));
    }

    public function notification(Request $request){
        $inputs = $request->all();
        $customer_id = "";
        $notification_type = "";
        try{
            if(isset($inputs['MerchantCustomerID'])){
                $customer_id = $inputs['MerchantCustomerID'];
                $notification_type = $inputs['NotificationType'];
                Notification::create(['raw' =>
                    json_encode([
                        'customer_id' => $customer_id,
                        'notification_type' => $notification_type
                    ])
                ]);
                if($notification_type == "CustomerProfile"){
                    // code to fetch customer profile
                }
            }
        }catch(Exception $e){

        }
        return response()->json([
            'Accepted' => true
        ]);
    }
}

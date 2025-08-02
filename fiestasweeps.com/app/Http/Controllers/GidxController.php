<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\GidxService;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $user = auth()->user();
        $gidx = new GidxCustomerIdentityService();
        $data = [
            'MerchantCustomerID' => 'CUST-' . Str::padLeft($user->id, 4, '0'),
            'FirstName' => $user->name,
            'LastName' => $user->lname,
            'EmailAddress' => $user->email,
            'MerchantSessionID' => (string) Str::uuid(),
            'DeviceIpAddress' => $req->ip()
        ];

        if($user->dob != null && $user->dob != ''){
            $date = Carbon::parse($user->dob);
            $data['DateOfBirth'] = $date->format('m/d/Y');
        }

        if($user->phone != null && $user->phone != ''){
            $data['MobilePhoneNumber'] = $user->phone;
        }

        if($req->location != '' && $req->location != null){
            $location = json_decode($req->location, true);
            $timestampInSeconds = $location['timestamp'] / 1000;
            $date = Carbon::createFromTimestamp($timestampInSeconds, 'GMT');
            $data['DeviceGPS'] = [
                'Latitude' => $location['coords']['latitude'],
                'Longitude' => $location['coords']['longitude'],
                'Radius' => $location['coords']['accuracy'],
                'Altitude' => $location['coords']['altitude'],
                'Speed' => $location['coords']['speed'],
                'DateTime' => $date->format('m/d/Y H:i:s T'),
            ];
        }

        if($user->verified == null || $user->verified == ''){
            $response = $gidx->customerRegistration($data);
        } else {
            $response = $gidx->customerUpdate($data);
        }
        $verified = false;

        if($response) {
            $u = User::find($user->id);
            if(in_array('ID-VERIFIED', $response['ReasonCodes'])){
                $u->verified = 1;
                $verified = true;
            } else {
                $u->verified = 0;
            }
            $u->save();
        }
        return response()->json(['status' => 'success', 'verified' => $verified]);
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

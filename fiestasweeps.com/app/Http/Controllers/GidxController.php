<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\GidxService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $user = User::find(auth()->user()->id);
        $user->name = $req->name;
        $user->lname = $req->lname;
        $user->phone = $req->phone;
        $user->dob = $req->dob;
        $user->save();

        $gidx = new GidxService();
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

        if($req->AddressLine1 != null && $req->AddressLine1 != ''){
            $data['AddressLine1'] = $req->AddressLine1;
        }
        if($req->AddressLine2 != null && $req->AddressLine2 != ''){
            $data['AddressLine2'] = $req->AddressLine2;
        }
        if($req->City != null && $req->City != ''){
            $data['City'] = $req->City;
        }
        if($req->StateCode != null && $req->StateCode != ''){
            $data['StateCode'] = $req->StateCode;
        }
        if($req->PostalCode != null && $req->PostalCode != ''){
            $data['PostalCode'] = $req->PostalCode;
        }
        if($req->CountryCode != null && $req->CountryCode != ''){
            $data['CountryCode'] = $req->CountryCode;
        }
        $response = null;
        if($user->verified == null || $user->verified == ''){
            $response = $gidx->customerRegistration($data);
        } else {
            $response = $gidx->customerUpdate($data);
        }
        $verified = false;

        if($response) {
            Log::info('Gidx Response', $response);
            if(in_array('ID-VERIFIED', $response['ReasonCodes'])){
                $user->verified = 1;
                $verified = true;
            } else {
                $user->verified = 0;
            }
            $user->save();
        } else {
            Log::error('Gidx Response Error', ['response' => 'Response Null']);
        }
        return response()->json(['status' => 'success', 'verified' => $verified]);
    }

    public function notification(Request $request){
        $inputs = $request->all();
        $customer_id = "";
        $notification_type = "";
        try{
            Log::info('Gidx Notification', $request->all());
            if(isset($inputs['MerchantCustomerID'])){
                $customer_id = $inputs['MerchantCustomerID'];
                $notification_type = $inputs['NotificationType'];
                if($notification_type == "CustomerProfile"){
                    $gidx = new GidxService();
                    $user = User::find((explode('-', $customer_id))[1]);
                    $response = $gidx->customerProfile($customer_id);
                    if($response) {
                        Log::info('Gidx Response', $response);
                        if(in_array('ID-VERIFIED', $response['ReasonCodes'])){
                            $user->verified = 1;
                            $verified = true;
                        } else {
                            $user->verified = 0;
                        }
                        $user->save();
                    } else {
                        Log::error('Gidx Response Error', ['response' => 'Response Null']);
                    }
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

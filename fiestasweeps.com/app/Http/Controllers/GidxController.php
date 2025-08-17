<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Services\GidxService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GidxController extends Controller
{
    public function customerRegistration(Request $req){
        $user = User::find(auth()->user()->id);
        $user->name = $req->fname;
        $user->lname = $req->lname;
        $user->phone = $req->phone;
        $user->dob = $req->dob;
        $user->save();
        $customer = null;
        try{
            $customer = Customer::where('users', $user->id)->firstOrFail();
        }catch(\Exception $e){
            $customer = Customer::create([
                'customer_id' => (string) Str::uuid(),
                'users' => $user->id
            ]);
        }
        $gidx = new GidxService();
        $data = [
            'MerchantCustomerID' => $customer->customer_id,
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
            $location = $req->location;
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
            if(array_key_exists('ReasonCodes', $response)){
                $customer->reasons = implode(',', $response['ReasonCodes']);
                $customer->save();
                if(in_array('ID-VERIFIED', $response['ReasonCodes'])){
                    $user->verified = 1;
                    $verified = true;
                } else {
                    $user->verified = 0;
                }
                $user->save();
            }
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
                    try{
                        $customer = Customer::where('customer_id', $customer_id)->firstOrFail();
                        $user = $customer->user();
                        $gidx = new GidxService();
                        $response = $gidx->customerProfile([
                            'MerchantCustomerID' => $customer_id,
                            'MerchantSessionID' => (string) Str::uuid(),
                        ]);
                        if($response) {
                            Log::info('Gidx Response', $response);
                            if(array_key_exists('ReasonCodes', $response)){
                                $customer->reasons = implode(',', $response['ReasonCodes']);
                                $customer->save();
                                if(in_array('ID-VERIFIED', $response['ReasonCodes'])){
                                    $user->verified = 1;
                                    $verified = true;
                                } else {
                                    $user->verified = 0;
                                }
                                $user->save();
                            }
                        } else {
                            Log::error('Gidx Response Error', ['response' => 'Response Null']);
                        }
                    }catch(\Exception $e){}
                }
            }
        }catch(Exception $e){

        }
        return response()->json([
            'Accepted' => true
        ]);
    }

    public function cashierPay(Request $req){
        $session_id = (string) Str::uuid();
        $transaction_id = (string) Str::uuid();
        $customer = Customer::where('users', auth()->user()->id)->firstOrFail();
        $gidx = new GidxService();
        $data = [
            'MerchantCustomerID' => $customer->customer_id,
            'MerchantOrderID' => $transaction_id,
            'MerchantTransactionID' => $transaction_id,
            'PayActionCode' => 'PAY',// PAYOUT, LOG
            'RedirectURL' => route('gidx.redirect', ['sessionId' => $session_id]),
            'CallbackURL' => route('gidx.callback', ['sessionId' => $session_id]),
            'MerchantSessionID' => $session_id,
            'CustomerIpAddress' => $req->ip()
        ];

        if($req->location != '' && $req->location != null){
            $location = $req->location;
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
        $response = $gidx->createSession($data);
        Log::info('Gidx Create Session Response: ', $response);

        // complete session call
        $response2 = $gidx->completeSession([
            'MerchantTransactionID' => $transaction_id,
            'MerchantSessionID' => $session_id,
            'PaymentAmount' => [
                'PaymentAmount' => 10.0,
                'BonusAmount' => 0.0,
                'BonusDetails' => "No Bonus",
                'FeeAmount' => 0.50,
                'TaxAmount' => 0.0,
                'OverrideLimit' => false,
                'CurrencyCode' => 'USD'
            ],
            'PaymentMethod' => [

            ],
        ]);
        Log::info('Gidx Complete Session Response: ', $response2);
        return response()->json($response2);
    }

    public function gidx_redirect(Request $req, $sessionId){
        Log::info('Gidx Redirect: ', [
            "Request" => $req,
            "Session" => $sessionId,
        ]);
        return response()->json([
            'Accepted' => true
        ]);
    }
    public function gidx_callback(Request $req, $sessionId){
        Log::info('Gidx Callback: ', [
            "Request" => $req,
            "Session" => $sessionId,
        ]);
        return response()->json([
            'Accepted' => true
        ]);

    }

    public function createSession(Request $req){
        $session_id = (string) Str::uuid();
        $transaction_id = (string) Str::uuid();
        $customer = Customer::where('users', auth()->user()->id)->firstOrFail();
        $gidx = new GidxService();
        $data = [
            'MerchantCustomerID' => $customer->customer_id,
            'MerchantOrderID' => $transaction_id,
            'MerchantTransactionID' => $transaction_id,
            'PayActionCode' => 'PAY',// PAYOUT, LOG
            'RedirectURL' => route('gidx.redirect', ['sessionId' => $session_id]),
            'CallbackURL' => route('gidx.callback', ['sessionId' => $session_id]),
            'MerchantSessionID' => $session_id,
            'CustomerIpAddress' => $req->ip()
        ];

        if($req->location != '' && $req->location != null){
            $location = $req->location;
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
        $response = $gidx->createSession($data);
        Log::info('Gidx Create Session Response: ', $response);
        return response()->json($response);
    }

    public function completeSession(Request $req){
        Log::info('Gidx Complete Session Request: ', $req->all());
        $response = $gidx->completeSession($req->all());
        Log::info('Gidx Complete Session Response: ', $response);
        return response()->json($response);
    }

    public function paymentMethods(){
        return view('payment');
    }


}

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
use Illuminate\Support\Facades\Log;

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
        try{
            Log::info('Complete Request:', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'headers' => $request->headers->all(),
                'inputs' => $request->all(),
                'query' => $request->query(),
                'rawContent' => $request->getContent(),
            ]);
        }catch(Exception $e){

        }
        try{
            Notification::create(['raw' =>
                json_encode([
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'headers' => $request->headers->all(),
                    'inputs' => $request->all(),
                    'query' => $request->query(),
                    'rawContent' => $request->getContent(),
                ])
            ]);
        } catch(Exception $e){

        }
        return response()->json([
            'Accepted' => true
        ]);
    }
}

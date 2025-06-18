<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHandle;
use App\Models\UserHandle;

class PaymentHandleController extends Controller
{
    public function index(){
        $user = auth()->user();
        if ($user->hasRole('Admin')){
            return response()->json(PaymentHandle::with('gateway', 'users')->get());
        }
        $userHandle = null;
        $paymentHandlesIds = [];
        if ($user->hasRole('Supervisor')){
            $userHandle = UserHandle::where('user_id', $user->id)->get();
        }
        if ($user->hasRole('Agent')) {
            $userHandle = UserHandle::where('user_id', $user->parent->id)->get();
        }
        if($userHandle->count() > 0) {
            foreach ($userHandle as $handle) {
                $paymentHandlesIds[] = $handle->handle_id;
            }
        }
        return response()->json(PaymentHandle::with('gateway', 'users')->whereIn('id', $paymentHandlesIds)->get());
    }

    public function store(Request $request){
        try{
            $request->validate([
                'gateway_id' => 'required|exists:payment_gateways,id',
                'account_handle' => 'required|string|max:255',
            ]);

            $handle = PaymentHandle::create([
                'gateway_id' => $request->gateway_id,
                'account_name' => $request->account_name,
                'account_handle' => $request->account_handle,
                'description' => $request->description,
                'status' => $request->status,
                'daily_limit' => '1000',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment handle created successfully',
                'data' => $handle
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while creating Payment handle',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id){
        try{
            $handle = PaymentHandle::with('users')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Payment handle fetched successfully',
                'data' => $handle
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Handle Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function update($id, Request $request){
        try{
            $handle = PaymentHandle::findOrFail($id);
            $handle->gateway_id = $request->gateway_id;
            $handle->account_name = $request->account_name;
            $handle->account_handle = $request->account_handle;
            $handle->description = $request->description;
            $handle->status = $request->status;
            $handle->save();
            $supervisor = $request->supervisor;

            try{
                UserHandle::where('handle_id', $id)->delete();
            }catch(\Exception $e){

            }

            UserHandle::create([
                'handle_id' => $id,
                'user_id' => $supervisor,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment handle updated successfully',
                'data' => $handle
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Payment handle Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try{
            $handle = PaymentHandle::findOrFail($id);
            $handle->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Payment handle deleted successfully',
                'data' => $handle
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Payment handle Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }
}


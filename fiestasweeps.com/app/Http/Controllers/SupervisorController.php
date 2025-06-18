<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index(){
        return response()->json(User::role('Supervisor')->get());
    }

    public function store(Request $request){
        try{
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);


            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'parent_id' => auth()->user()->id,
                'password' => Hash::make($request->password),
            ]);

            if($request->has('status')){
                $user->status = $request->status;
            }

            $user->assignRole('Supervisor');
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Supervisor created successfully',
                'data' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while creating supervisor',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id){
        try{
            $user = User::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Supervisor fethed successfully',
                'data' => $user
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Supervisor Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function update($id, Request $request){
        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->status = $request->status;
            if($request->password != ''){
                if($request->password == $request->password_confirmation){
                    $user->password = Hash::make($request->password);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Password & Confirm Password didn\'t match.',
                        'errors' => []
                    ], 422);
                }
            }
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Supervisor updated successfully',
                'data' => $user
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Supervisor Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Supervisor deleted successfully',
                'data' => $user
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Supervisor Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.signin');
    }

    public function showRegister()
    {
        return view('pages.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        try{
            $validated = $request->validate([
                'fname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }

        $user = User::create([
            'name' => trim($validated['fname']),
            'lname' => $request->input('lname', ''), // Optional last name
            'phone' => $request->input('phone', ''), // Optional phone number
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('pages.dashboard', compact('user'));
    }

    public function statsUpdate(Request $request)
    {
        $stat = $request->stat_name;
        $user = Auth::user();
        $user->{$stat} = $request->value;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => "Your $stat has been updated successfully.",
            'value' => $user->{$request->stat_name}
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'dob' => 'nullable|date',
        ]);

        $user->name = trim($validated['name']);
        $user->lname = $validated['lname'] ?? '';
        $user->phone = $validated['phone'];
        $user->dob = $validated['dob'];
        $user->save();

        return redirect()->back()->with('status', 'Profile updated successfully.');
    }
}

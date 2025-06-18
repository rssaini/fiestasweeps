<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\PaymentGateway;
use App\Models\PaymentHandle;
use App\Models\Transaction;
use App\Models\UserHandle;
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
            $user = auth()->user();
            if($user->status == 0){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'status' => 'User is Disabled',
                ]);
            }
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

        $user->assignRole('Player');

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
        if (!$user) {
            return redirect()->route('login');
        }
        if ($user->hasRole('Player')) {
            return view('pages.dashboard', compact('user'));
        }

        $games = Game::all();
        $gateways = PaymentGateway::all();

        return view('adash', compact('user', 'games', 'gateways'));
    }

    public function createTransaction(Request $request)
    {
        $transaction = new Transaction();
        $transaction->player_id = $request->player_id;
        $transaction->game_id = $request->game_id;
        $transaction->amount = $request->amount;
        $transaction->points = $request->points;
        $transaction->created_by = Auth::id();
        // $transaction->updated_by = Auth::id();

        if($request->transaction_type === 'deposit') {

        } else {
            $transaction->last_deposit = $request->last_deposit;
            $transaction->deposit_handle_id = $request->deposit_handle_id;
        }

        $transaction->handle_id = $request->payment_handle;
        $transaction->player_handle = $request->player_handle;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->status = 'pending'; // Default status

        $transaction->save();

        return response()->json([
            'status' => 'success',
            'message' => "Transaction created successfully.",
        ]);
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

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'pwd' => 'required',
            'npwd' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['pwd'], $user->password)) {
            return back()->withErrors(['pwd' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($validated['npwd']);
        $user->save();

        return redirect()->back()->with('status', 'Password updated successfully.');
    }
}

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
        $supervisors = User::role('Supervisor')->get();
        $agents = null;
        $games = Game::all();
        $gateways = PaymentGateway::all();

        $transactions = [];
        $cashouts = [];

        $paymentHandles = [];

        $userHandle = null;
        if ($user->hasRole('Admin')){
            $agents = User::role('Agent')->get();
            $Handles = PaymentHandle::all();
            foreach ($Handles as $handle) {
                $paymentHandles[] = $handle;
            }
            $transactions = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->where('transaction_type', 'deposit')
                ->orderBy('created_at', 'desc')
                ->get();
            $cashouts = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->where('transaction_type', 'cashout')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($user->hasRole('Supervisor')) {
            $userHandle = UserHandle::where('user_id', $user->id)->get();
            $agents = User::role('Agent')->where('parent_id', $user->id)->get();

            $user_ids = [];
            $user_ids[] = $user->id; // Include the supervisor's own ID
            $user->children->pluck('id')->each(function ($childId) use (&$user_ids) {
                $user_ids[] = $childId;
            });

            $transactions = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->whereIn('created_by', $user_ids)
                ->where('transaction_type', 'deposit')
                ->orderBy('created_at', 'desc')->get();

            $cashouts = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->whereIn('created_by', $user_ids)
                ->where('transaction_type', 'cashout')
                ->orderBy('created_at', 'desc')
                ->get();

        }
        if ($user->hasRole('Agent')) {
            $userHandle = UserHandle::where('user_id', $user->parent->id)->get();
            $transactions = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->where('created_by', $user->id)
                ->where('transaction_type', 'deposit')
                ->orderBy('created_at', 'desc')->get();
            $cashouts = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'handle'])
                ->where('created_by', $user->id)
                ->where('transaction_type', 'cashout')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($user->hasRole('Supervisor') || $user->hasRole('Agent')) {
            if($userHandle->count() > 0) {
                foreach ($userHandle as $handle) {
                    $paymentHandles[] = $handle->handle;
                }
            }
        }


        if ($user->hasRole('Player')) {
            return view('pages.dashboard', compact('user'));
        }
        return view('adash', compact('user','supervisors', 'agents', 'games', 'gateways', 'paymentHandles', 'transactions', 'cashouts'));
    }

    public function createAdminUser(Request $request)
    {

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'parent_id' => $request->parent_id,
            'password' => Hash::make($request->password),
        ]);


        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Supervisor created successfully.');
    }

    public function createGame(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the game record
        $game = new Game();
        $game->name = $request->name;
        $game->description = $request->description;
        $game->save();

        return redirect()->back()->with('success', 'Game created successfully.');
    }

    public function addPaymentMethod(Request $request)
    {
        $request->validate([
            'gateway_id' => 'required|exists:payment_gateways,id',
            'account_handle' => 'required|string|max:255',
        ]);

        PaymentHandle::create([
            'gateway_id' => $request->gateway_id,
            'account_name' => $request->account_name,
            'account_handle' => $request->account_handle,
            'description' => $request->description,
            'status' => $request->status,
            'daily_limit' => $request->daily_limit,
        ]);

        return redirect()->back()->with('success', 'Payment method added successfully.');
    }

    public function updateUserHandle(Request $request)
    {
        $handle_id = $request->handle_id;
        $user_id = $request->user_id;
        $user = Auth::user();

        if (!($user->hasRole('Admin'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to update this handle.'
            ], 403);
        }
        UserHandle::where('handle_id', $handle_id)->delete();
        UserHandle::create([
            'handle_id' => $handle_id,
            'user_id' => $user_id,
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Your handle has been updated successfully.',
            'handle' => $user->handle
        ]);
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

        return redirect()->back()->with('success', 'Transaction created successfully.');
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

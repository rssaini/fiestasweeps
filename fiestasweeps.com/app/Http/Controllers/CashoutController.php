<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class CashoutController extends Controller
{
    public function index() {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $transactions = Transaction::with(['game', 'createdBy', 'updatedBy', 'depositHandle', 'depositHandle.gateway', 'handle', 'handle.gateway'])->where('transaction_type', 'cashout');

        if ($user->hasRole('Supervisor')) {
            $user_ids = [];
            $user_ids[] = $user->id; // Include the supervisor's own ID
            $user->children->pluck('id')->each(function ($childId) use (&$user_ids) {
                $user_ids[] = $childId;
            });

            $transactions = $transactions->whereIn('created_by', $user_ids);
        }
        if ($user->hasRole('Agent')) {
            $transactions = $transactions->where('created_by', $user->id);
        }
        if(request()->has('start_date') && request()->has('end_date')) {
            $startDate = request()->input('start_date');
            $endDate = request()->input('end_date');
            $transactions = $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }
        if(request()->has('page')) {
            if(request()->has('pageSize')){
                $transactions = $transactions->orderBy('created_at', 'desc')->paginate(request()->input('pageSize'));
            } else {
                $transactions = $transactions->orderBy('created_at', 'desc')->paginate(10);
            }
        } else {
            $transactions = $transactions->orderBy('created_at', 'desc')->get();
        }

        if(request()->has('export') && request()->input('export') == 'csv') {
            $filename = "cashouts_" . now()->format('Ymd_His') . ".csv";
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use ($transactions) {
                $file = fopen('php://output', 'w');
                // Add headings
                fputcsv($file, ['ID','Player ID', 'Game','Last Deposit', 'Deposit Method', 'Deposit Handle' ,'AMOUNT', 'Payment Method', 'Payment Handle', 'Player Handle', 'Points Value', 'Created By','Updated By', 'Date', 'STATUS']);

                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->id,
                        $transaction->player_id,
                        $transaction->game ? $transaction->game->name : 'N/A',
                        $transaction->last_deposit,
                        $transaction->depositHandle ? $transaction->depositHandle->gateway->name : 'N/A',
                        $transaction->depositHandle ? $transaction->depositHandle->account_handle : 'N/A',
                        $transaction->amount,
                        $transaction->handle ? $transaction->handle->gateway->name : 'N/A',
                        $transaction->handle ? $transaction->handle->account_handle : 'N/A',
                        $transaction->player_handle,
                        $transaction->points,
                        $transaction->createdBy ? $transaction->createdBy->name . '('. $transaction->createdBy->role .')': 'N/A',
                        $transaction->updatedBy ? $transaction->updatedBy->name . '('. $transaction->updatedBy->role .')': 'N/A',
                        $transaction->created_at->format('Y-m-d H:i:s'),
                        $transaction->status,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return response()->json($transactions);
    }

    public function create()
    {
        return view('transactions.create');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'transaction_type' => 'required|string|in:deposit,withdrawal',
            'user_id' => 'required|exists:users,id',
        ]);

        // Create a new transaction
        $transaction = new \App\Models\Transaction();
        $transaction->amount = $request->amount;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->user_id = $request->user_id;
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
    public function show($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }
    public function edit($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'transaction_type' => 'required|string|in:deposit,withdrawal',
            'user_id' => 'required|exists:users,id',
        ]);

        // Update the transaction
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->amount = $request->amount;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->user_id = $request->user_id;
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }
    public function destroy($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}

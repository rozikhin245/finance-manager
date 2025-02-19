<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id()); // Hanya transaksi milik user yang login
    
        // Filter berdasarkan tanggal
        if ($request->has('filter_type')) {
            if ($request->filter_type === 'daily' && $request->date) {
                $query->whereDate('date', $request->date);
            } elseif ($request->filter_type === 'monthly' && $request->month) {
                $query->whereYear('date', date('Y', strtotime($request->month)))
                      ->whereMonth('date', date('m', strtotime($request->month)));
            } elseif ($request->filter_type === 'yearly' && $request->year) {
                $query->whereYear('date', $request->year);
            }
        }
    
        $transactions = $query->orderBy('date', 'desc')->get();
    
        return view('transactions.index', compact('transactions'));
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // $this->authorize('update', $transaction);

        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
    
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
    
}

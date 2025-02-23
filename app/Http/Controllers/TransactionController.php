<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
    
        $transactions = $query->orderBy('id', 'desc')->get();
        
    
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
        // Validasi input
        $request->validate([
            'type' => 'required|string',
            'category' => 'required|string',
            'other_category' => 'nullable|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Jika kategori yang dipilih adalah "other", gunakan nilai dari input "other_category"
        $category = ($request->category === 'other' && !empty($request->other_category))
            ? $request->other_category
            : $request->category;

        // Simpan transaksi ke database dengan tanggal otomatis
        Transaction::create([
            'user_id' => auth()->id(), // Ambil ID pengguna yang sedang login
            'type' => $request->type,
            'category' => $category,
            'amount' => $request->amount,
            'date' => Carbon::now(), // Otomatis menggunakan waktu saat ini
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

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
    
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
    
}

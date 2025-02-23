<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Hitung total pemasukan & pengeluaran
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $sama = $balance;


        // Ambil transaksi terbaru (5 terakhir)
        $recentTransactions = Transaction::where('user_id', $userId)
            // // ->orderBy('date', 'desc') // Urutkan dari tanggal terbaru
            ->orderBy('id', 'desc') // Urutkan dari transaksi terbaru yang diinput
            ->take(5)
            ->get();

        // Data untuk grafik (group by bulan)
        $monthlyData = Transaction::where('user_id', $userId)
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, type, SUM(amount) as total')
            ->groupBy('year', 'month', 'type')
            ->get();

        // Query transaksi berdasarkan user login
        $query = Transaction::where('user_id', Auth::id());

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

        // Ambil transaksi setelah difilter
        $transactions = $query->orderBy('id', 'desc')->get();

        return view('dashboard.index', compact('totalIncome', 'totalExpense', 'balance', 'recentTransactions', 'monthlyData', 'transactions','sama'));
    }
}

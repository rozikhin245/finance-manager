<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Hitung total pemasukan & pengeluaran
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Ambil transaksi terbaru (5 terakhir)
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Data untuk grafik (group by bulan)
        $monthlyData = Transaction::where('user_id', $userId)
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, type, SUM(amount) as total')
            ->groupBy('year', 'month', 'type')
            ->get();

        return view('dashboard.index', compact('totalIncome', 'totalExpense', 'balance', 'recentTransactions', 'monthlyData'));
    }
}

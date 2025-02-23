<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Hitung total pemasukan & pengeluaran
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $sama = $balance;

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

        return view('HomePage.index', compact('totalIncome', 'totalExpense', 'balance', 'recentTransactions', 'monthlyData','sama'));
    }
}

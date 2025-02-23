<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\SavingTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingTargetController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $targets = SavingTarget::where('user_id', Auth::id())->get();
        $balance = Auth::user()->balance; // Ambil saldo user
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $sama = $balance;


        return view('saving-targets.index', compact('targets', 'balance', 'totalIncome', 'sama'));
    }
}

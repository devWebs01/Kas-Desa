<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function print(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $filterCategory = $request->query('filterCategory');
        $filterKeyword = $request->query('filterKeyword');

        $transactions = Transaction::with('recipient')
            ->when(
                $startDate && $endDate,
                fn ($query) => $query->whereBetween('date', [$startDate, $endDate])
            )
            ->when(
                $filterCategory,
                fn ($query) => $query->where('category', $filterCategory)
            )
            ->when($filterKeyword, function ($query) use ($filterKeyword) {
                $query->where(function ($q) use ($filterKeyword) {
                    $q->whereHas('recipient', fn ($r) => $r->where('name', 'like', "%{$filterKeyword}%"))
                        ->orWhere('title', 'like', "%{$filterKeyword}%")
                        ->orWhere('invoice', 'like', "%{$filterKeyword}%");
                });
            })
            ->orderBy('date', 'asc')
            ->get();

        $totalDebit = $transactions->where('category', 'debit')->sum('amount');
        $totalCredit = $transactions->where('category', 'credit')->sum('amount');
        $endingBalance = $totalDebit - $totalCredit;

        return view('pages.reports.transaction-print', compact(
            'transactions',
            'totalDebit',
            'totalCredit',
            'endingBalance'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request): Response
    {
        $transactions = Transaction::all();

        return view('transaction.index', [
            'transactions' => $transactions,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('transaction.create');
    }

    public function store(TransactionStoreRequest $request): Response
    {
        $transaction = Transaction::create($request->validated());

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transactions.index');
    }

    public function show(Request $request, Transaction $transaction): Response
    {
        return view('transaction.show', [
            'transaction' => $transaction,
        ]);
    }

    public function edit(Request $request, Transaction $transaction): Response
    {
        return view('transaction.edit', [
            'transaction' => $transaction,
        ]);
    }

    public function update(TransactionUpdateRequest $request, Transaction $transaction): Response
    {
        $transaction->update($request->validated());

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transactions.index');
    }

    public function destroy(Request $request, Transaction $transaction): Response
    {
        $transaction->delete();

        return redirect()->route('transactions.index');
    }
}

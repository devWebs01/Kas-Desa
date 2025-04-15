<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function create()
    {
        // Menampilkan halaman form untuk menambah transaksi
        $recipients = Recipient::all();
        return view('transactions.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'category' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'invoice' => ['nullable', 'string', 'unique:transactions,invoice'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'recipient_id' => ['required', 'integer', 'exists:recipients,id'],
        ]);

        // Membuat transaksi baru
        Transaction::create($validatedData);

        // Memberikan notifikasi sukses dan redirect
        session()->flash('message', 'Data transaksi berhasil disimpan!');
        return redirect()->route('transactions.index');
    }

    public function edit($id)
    {
        // Menampilkan halaman edit transaksi
        $transaction = Transaction::findOrFail($id);
        $recipients = Recipient::all();
        return view('transactions.edit', compact('transaction', 'recipients'));
    }

    public function getRecipientData($recipientId)
    {
        $recipient = Recipient::find($recipientId);
        return response()->json($recipient);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required|string',
            'recipient_id' => 'required|exists:recipients,id',
            'signature' => 'nullable|string', // Tanda tangan dapat berupa string base64
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category' => $request->category,
            'recipient_id' => $request->recipient_id,
            'signature' => $request->signature, // Menyimpan tanda tangan dalam bentuk base64
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }
}

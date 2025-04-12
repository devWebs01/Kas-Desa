<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipientStoreRequest;
use App\Http\Requests\RecipientUpdateRequest;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\View\View; // tambahkan di atas kalau belum ada

class RecipientController extends Controller
{
    public function index(Request $request): View
    {
        $recipients = Recipient::all();

        return view('recipient.index', [
            'recipients' => $recipients,
        ]);
    }

    public function create(Request $request): View
    {
        return view('recipient.create');
    }

    public function store(RecipientStoreRequest $request): View
    {
        $recipient = Recipient::create($request->validated());

        $request->session()->flash('recipient.id', $recipient->id);

        return redirect()->route('recipients.index');
    }

    public function show(Request $request, Recipient $recipient): View
    {
        return view('recipient.show', [
            'recipient' => $recipient,
        ]);
    }

    public function edit(Request $request, Recipient $recipient): View
    {
        return view('recipient.edit', [
            'recipient' => $recipient,
        ]);
    }

    public function update(RecipientUpdateRequest $request, Recipient $recipient): View
    {
        $recipient->update($request->validated());

        $request->session()->flash('recipient.id', $recipient->id);

        return redirect()->route('recipients.index');
    }

    public function destroy(Request $request, Recipient $recipient): View
    {
        $recipient->delete();

        return redirect()->route('recipients.index');
    }
}

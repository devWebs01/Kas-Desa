<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function saveSignature(Request $request, Item $item)
    {
        $request->validate([
            'authorized' => 'required|string',
            'signature_data' => 'required|string',
            'signature_code' => 'required|string',
        ]);

        // Proses simpan gambar
        $signatureImage = str_replace('data:image/png;base64,', '', $request->signature_data);
        $signatureImage = str_replace(' ', '+', $signatureImage);
        $imageData = base64_decode($signatureImage);

        $filePath = "signatures/item_{$item->id}.png";
        Storage::put("public/{$filePath}", $imageData);

        $item->update([
            "authorized"=> $request->authorized,
            'signature' => $filePath,
            'signature_code' => $request->signature_code,
        ]);

        return redirect()->route('transactions.show', ['transaction' => $item->transaction])->with('success', 'Tanda tangan berhasil disimpan!');
    }
}

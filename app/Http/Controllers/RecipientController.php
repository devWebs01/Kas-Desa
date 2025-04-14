<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipientController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|digits_between:11,13|numeric',
            'signature' => 'required|string',
            'signature_code' => 'required|string',
        ]);

        $signatureData = $request->input('signature');
        $signatureName = 'signature_' . time() . '.png';

        if (preg_match('/^data:image\/(\w+);base64,/', $signatureData)) {
            $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
            $signatureData = base64_decode($signatureData);

            Storage::put("public/signatures/{$signatureName}", $signatureData);
        }

        Recipient::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'signature' => "signatures/{$signatureName}",
            'signature_code' => $request->signature_code,
        ]);

        return redirect()->route('recipients.index')->with('success', 'Penerima berhasil ditambahkan.');
    }

    public function update(Request $request, Recipient $recipient)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|digits_between:11,13|numeric',
            'signature' => 'nullable|string',
            'signature_code' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        if ($request->filled('signature') && $request->filled('signature_code')) {
            $signatureData = $request->input('signature');
            $signatureName = 'signature_' . time() . '.png';

            if (preg_match('/^data:image\/(\w+);base64,/', $signatureData)) {
                $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
                $signatureData = base64_decode($signatureData);

                // Hapus tanda tangan lama kalau ada
                if ($recipient->signature && Storage::exists('public/' . $recipient->signature)) {
                    Storage::delete('public/' . $recipient->signature);
                }

                Storage::put("public/signatures/{$signatureName}", $signatureData);

                $data['signature'] = "signatures/{$signatureName}";
                $data['signature_code'] = $request->signature_code;
            }
        }

        $recipient->update($data);

        return redirect()->route('recipients.index')->with('success', 'Penerima berhasil diperbarui.');
    }


}

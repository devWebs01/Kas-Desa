<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{
    public function show()
    {
        $setting = Setting::first();

        return view('pages.settings.show', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        if (!$setting) {
            return redirect()->back()->withErrors(['setting' => 'Pengaturan tidak ditemukan.']);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'signature_data' => 'nullable|string', // Base64 data
            'signature_code' => 'nullable|string', // JSON stroke
            'responsible_person' => 'required|string', // JSON stroke
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Data yang akan diupdate
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'signature_code' => $request->input('signature_code'),
            'responsible_person' => $request->input('responsible_person'),
        ];

        // 🛠 Simpan tanda tangan sebagai file gambar
        $signatureData = $request->input('signature_data');
        if (!empty($signatureData)) {
            $folderPath = 'public/signatures/';

            // // Cek dan buat folder jika belum ada
            // if (!Storage::exists($folderPath)) {
            //     Storage::makeDirectory($folderPath, 0755, true);
            // }

            // Hapus tanda tangan lama jika ada
            if (!empty($setting->signature) && Storage::exists($setting->signature)) {
                Storage::delete($setting->signature);
            }

            // Dekode base64 menjadi file gambar
            [$meta, $content] = explode(';base64,', $signatureData);
            [$type, $ext] = explode('/', str_replace('data:', '', $meta));
            $imageData = base64_decode($content);

            // Buat nama file unik
            $fileName = uniqid() . '.' . $ext;
            $filePath = $folderPath . $fileName;

            // Simpan file ke storage
            Storage::put($filePath, $imageData);

            // Simpan path ke database
            $data['signature'] = $filePath;
        }

        // Update data
        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function destroy()
    {
        $setting = Setting::first();

        if (!$setting) {
            return redirect()->back()->withErrors(['setting' => 'Pengaturan tidak ditemukan.']);
        }

        // Hapus file signature jika ada
        if (!empty($setting->signature) && Storage::exists($setting->signature)) {
            Storage::delete($setting->signature);
        }

        // Kosongkan kolom signature dan signature_code
        $setting->update([
            'signature' => null,
            'signature_code' => null,
        ]);

        return redirect()->back()->with('success', 'Tanda tangan berhasil dihapus.');
    }
}

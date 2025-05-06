<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'Kas Adat Kelurahan Dusun Kebun',
            'address' => 'Dusun Kebun, Batang Asam, Tanjung Jabung Barat',
            'responsible_person' => fake()->name(),
            'signature' => '',
            'signature_code' => '',
        ]);
    }
}

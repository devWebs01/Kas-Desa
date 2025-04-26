<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RecipientSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk data penerima (recipients).
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Recipient::factory(20)->create();
    }
}

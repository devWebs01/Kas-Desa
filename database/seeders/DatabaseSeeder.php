<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Recipient;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'identity' => Str::random(10),
            'role' => 'ADMIN',
        ]);

        $this->call([
            RecipientSeeder::class,
            TransactionSeeder::class,
            SettingSeeder::class,
        ]);

        $recipients = Recipient::all();

        // Dua bulan terakhir (misalnya April dan Maret 2025 jika sekarang Mei 2025)
        $months = [
            now()->subMonth()->startOfMonth(), // bulan lalu
            now()->subMonths(2)->startOfMonth(), // dua bulan lalu
        ];

        foreach ($months as $month) {
            // Isi data untuk setiap hari kerja (Senin–Jumat) dalam bulan tersebut
            for ($day = 1; $day <= $month->daysInMonth; $day++) {
                $date = $month->copy()->day($day);

                if ($date->isWeekday()) {
                    // Tambahkan 1 debit dan 1 kredit per hari
                    foreach (['debit', 'credit'] as $category) {
                        Transaction::create([
                            'title' => fake()->sentence(),
                            'date' => $date->format('Y-m-d'),
                            'category' => $category,
                            'amount' => fake()->numberBetween(50000, 500000),
                            'recipient_id' => $recipients->random()->id,
                            'description' => ucfirst($category).' pada '.$date->format('d M Y'),
                        ]);
                    }
                }
            }
        }
    }
}

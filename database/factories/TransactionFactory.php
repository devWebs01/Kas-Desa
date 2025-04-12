<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Recipient;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'category' => fake()->randomElement(["credit","debit"]),
            'amount' => fake()->numerify() . '000',
            'invoice' => fake()->word(),
            'date' => fake()->date(),
            'description' => fake()->text(),
            'recipient_id' => Recipient::factory(),
        ];
    }
}

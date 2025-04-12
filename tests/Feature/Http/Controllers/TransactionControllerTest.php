<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Recipient;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransactionController
 */
final class TransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $transactions = Transaction::factory()->count(3)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertViewIs('transaction.index');
        $response->assertViewHas('transactions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('transactions.create'));

        $response->assertOk();
        $response->assertViewIs('transaction.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'store',
            \App\Http\Requests\TransactionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $category = fake()->randomElement(/** enum_attributes **/);
        $amount = fake()->word();
        $date = Carbon::parse(fake()->date());
        $description = fake()->text();
        $recipient = Recipient::factory()->create();

        $response = $this->post(route('transactions.store'), [
            'title' => $title,
            'category' => $category,
            'amount' => $amount,
            'date' => $date->toDateString(),
            'description' => $description,
            'recipient_id' => $recipient->id,
        ]);

        $transactions = Transaction::query()
            ->where('title', $title)
            ->where('category', $category)
            ->where('amount', $amount)
            ->where('date', $date)
            ->where('description', $description)
            ->where('recipient_id', $recipient->id)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertRedirect(route('transactions.index'));
        $response->assertSessionHas('transaction.id', $transaction->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.show');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.edit', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.edit');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'update',
            \App\Http\Requests\TransactionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $transaction = Transaction::factory()->create();
        $title = fake()->sentence(4);
        $category = fake()->randomElement(/** enum_attributes **/);
        $amount = fake()->word();
        $date = Carbon::parse(fake()->date());
        $description = fake()->text();
        $recipient = Recipient::factory()->create();

        $response = $this->put(route('transactions.update', $transaction), [
            'title' => $title,
            'category' => $category,
            'amount' => $amount,
            'date' => $date->toDateString(),
            'description' => $description,
            'recipient_id' => $recipient->id,
        ]);

        $transaction->refresh();

        $response->assertRedirect(route('transactions.index'));
        $response->assertSessionHas('transaction.id', $transaction->id);

        $this->assertEquals($title, $transaction->title);
        $this->assertEquals($category, $transaction->category);
        $this->assertEquals($amount, $transaction->amount);
        $this->assertEquals($date, $transaction->date);
        $this->assertEquals($description, $transaction->description);
        $this->assertEquals($recipient->id, $transaction->recipient_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transactions.index'));

        $this->assertModelMissing($transaction);
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RecipientController
 */
final class RecipientControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $recipients = Recipient::factory()->count(3)->create();

        $response = $this->get(route('recipients.index'));

        $response->assertOk();
        $response->assertViewIs('recipient.index');
        $response->assertViewHas('recipients');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('recipients.create'));

        $response->assertOk();
        $response->assertViewIs('recipient.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RecipientController::class,
            'store',
            \App\Http\Requests\RecipientStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();
        $phone = fake()->phoneNumber();
        $signature = fake()->word();
        $signature_code = fake()->text();

        $response = $this->post(route('recipients.store'), [
            'name' => $name,
            'phone' => $phone,
            'signature' => $signature,
            'signature_code' => $signature_code,
        ]);

        $recipients = Recipient::query()
            ->where('name', $name)
            ->where('phone', $phone)
            ->where('signature', $signature)
            ->where('signature_code', $signature_code)
            ->get();
        $this->assertCount(1, $recipients);
        $recipient = $recipients->first();

        $response->assertRedirect(route('recipients.index'));
        $response->assertSessionHas('recipient.id', $recipient->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $recipient = Recipient::factory()->create();

        $response = $this->get(route('recipients.show', $recipient));

        $response->assertOk();
        $response->assertViewIs('recipient.show');
        $response->assertViewHas('recipient');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $recipient = Recipient::factory()->create();

        $response = $this->get(route('recipients.edit', $recipient));

        $response->assertOk();
        $response->assertViewIs('recipient.edit');
        $response->assertViewHas('recipient');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RecipientController::class,
            'update',
            \App\Http\Requests\RecipientUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $recipient = Recipient::factory()->create();
        $name = fake()->name();
        $phone = fake()->phoneNumber();
        $signature = fake()->word();
        $signature_code = fake()->text();

        $response = $this->put(route('recipients.update', $recipient), [
            'name' => $name,
            'phone' => $phone,
            'signature' => $signature,
            'signature_code' => $signature_code,
        ]);

        $recipient->refresh();

        $response->assertRedirect(route('recipients.index'));
        $response->assertSessionHas('recipient.id', $recipient->id);

        $this->assertEquals($name, $recipient->name);
        $this->assertEquals($phone, $recipient->phone);
        $this->assertEquals($signature, $recipient->signature);
        $this->assertEquals($signature_code, $recipient->signature_code);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $recipient = Recipient::factory()->create();

        $response = $this->delete(route('recipients.destroy', $recipient));

        $response->assertRedirect(route('recipients.index'));

        $this->assertModelMissing($recipient);
    }
}

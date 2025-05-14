<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Validation\ValidationException;
use App\Models\Recipient;
use App\Models\Message;
use App\Services\MessageEncryptionService;

class MessageControllerTest extends TestCase
{
    private $recipient;
    private $message;

    private static $password = 'password';
    private static $messageContents = 'SetUp contents';

    public function setUp() : void
    {
        parent::setUp();

        $this->recipient = Recipient::create([
            'name' => 'Test User',
            'email_address' => 'test@example.org'
        ]);

        $encryptionResult = MessageEncryptionService::encrypt(self::$messageContents);

        $this->message = Message::create([
            'contents' => $encryptionResult,
            'recipient_id' => $this->recipient->id,
            'password' => password_hash(self::$password, null)
        ]);
    }

    public function tearDown() : void
    {
        $this->message = null;
        $this->recipient = null;

        Message::query()->delete();
        Recipient::query()->delete();

        parent::tearDown();
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(config('app.name'));
        $response->assertSee('Plaats hier je bericht');
        $response->assertSee('Versleutel bericht');
    }

    public function test_store_message_failed_validation() : void
    {
        // * Invalid `recipient_id` and missing `contents`.
        $response = $this->post('/send', ['recipient_id' => 0]);

        $response->assertInvalid(['contents', 'recipient_id']);
    }

    public function test_store_message_failed_validation_no_recipient_info() : void
    {
        // * Missing `recipient_id` or `name` and `email_address`.
        $response = $this->post('/send', ['contents' => 'Test']);

        $response->assertInvalid(['recipient_id']);
    }

    public function test_store_message_failed_validation_both_recipient_options() : void
    {
        // * `recipient_id`, `name` and `email_address` are provided.
        $response = $this->post('/send', ['contents' => 'Test', 'recipient_id' => $this->recipient->id, 'name' => 'Test', 'email_address' => 'test@example.org']);

        $response->assertInvalid(['recipient_id']);
    }


    public function test_store_message_with_recipient_id_success() : void
    {
        $beforeCount = Message::count();

        $response = $this->post('/send', ['contents' => 'Test contents', 'recipient_id' => $this->recipient->id]);
        
        $currentCount = Message::count();

        $response->assertOk();
        $response->assertSee('Bericht verstuurd');
        $this->assertTrue($currentCount > $beforeCount);
    }

    public function test_store_message_other_success() : void
    {
        $beforeCount = Message::count();

        $response = $this->post('/send', ['contents' => 'Test contents', 'name' => 'Test User', 'email_address' => 'test@example.org']);
        
        $currentCount = Message::count();

        $response->assertOk();
        $response->assertSee('Bericht verstuurd');
        $this->assertTrue($currentCount > $beforeCount);
    }

    public function test_protected_show_expired_message() : void
    {
        $this->message->expires_at = now();
        $this->message->save();

        $messageUrl = url("/{$this->message->id}");

        $response = $this->get($messageUrl);

        $response->assertOk();
        $response->assertSee('Bericht verlopen');
    }

    public function test_protected_show_decryption_form() : void
    {
        $messageUrl = url("/{$this->message->id}");

        $response = $this->get($messageUrl);

        $response->assertOk();
        $response->assertSee('Bericht vergrendeld');
        
    }

    public function test_show_incorrect_password() : void
    {
        $messageUrl = url("/{$this->message->id}/decrypted");

        $response = $this->post($messageUrl, ['password' => 'incorrect']);
        $response->assertInvalid(['password']);
    }

    public function test_show_correct_password() : void
    {
        $messageUrl = url("/{$this->message->id}/decrypted");

        $response = $this->post($messageUrl, ['password' => self::$password]);
        $response->assertOk();
        $response->assertSee(self::$messageContents);
    }
}

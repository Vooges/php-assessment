<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MessageEncryptionService;
use App\Models\Recipient;
use Illuminate\Support\Facades\Http;

class MessageEncryptionServiceTest extends TestCase
{
    private static $decryptedMessageContent = 'Decrypted';

    public function test_encrypt_content() : void
    {
        $encrypted = MessageEncryptionService::encrypt(self::$decryptedMessageContent);

        $this->assertFalse($encrypted === self::$decryptedMessageContent);
    }

    public function test_decrypt_encrypted_content() : void
    {
       $encrypted = MessageEncryptionService::encrypt(self::$decryptedMessageContent);
       $decrypted = MessageEncryptionService::decrypt($encrypted);
       
       $this->assertTrue($decrypted === self::$decryptedMessageContent);
    }
}
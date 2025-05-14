<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use App\Models\Message;

class MessageEncryptionService
{
    public static function encrypt(string $text) : string
    {
        return Crypt::encryptString($text);
    }

    public static function decrypt(string $encrypted) : string
    {
        return Crypt::decryptString($encrypted);
    }
}
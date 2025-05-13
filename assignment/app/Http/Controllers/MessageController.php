<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\ShowMessageRequest;
use App\Services\ColleaguesAPIService;
use App\Services\MessageEncryptionService;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;

class MessageController extends Controller
{
    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        $colleagues = Recipient::get();

        return view('create', ['colleagues' => $colleagues]);
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $encryptionResult = MessageEncryptionService::encrypt($validated['contents']);
        $password = Str::password();

        $message = Message::create([
            'contents' => $encryptionResult,
            'recipient_id' => $validated['recipient_id'],
            'password' => password_hash($password, null)
        ]);

        $messageUrl = url("/{$message->id}");

        return view('sent', ['decryptionPassword' => $password, 'messageUrl' => $messageUrl]);
    }

    /**
     * Display the form to decrypt the message.
     */
    public function protectedShow(Message $message)
    {
        if (now()->gte($message->expires_at)){
            return view('expired');
        }

        $decryptedMessageUrl = url("/{$message->id}/decrypted");

        return view('protected-show', ['decryptedMessageUrl' => $decryptedMessageUrl]);
    }

    /**
     * Display the decrypted message.
     */
    public function show(Message $message, ShowMessageRequest $request)
    {
        $message->contents = MessageEncryptionService::decrypt($message->contents);

        return view('show', ['message' => $message]);
    }
}

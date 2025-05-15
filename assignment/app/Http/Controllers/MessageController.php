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

        $recipientId = isset($validated['recipient_id']) ? $validated['recipient_id'] : null;

        if ($recipientId === null){
            $recipient = Recipient::firstOrCreate(
                ['email_address' => $validated['email_address']],
                [
                    'name' => $validated['name'],
                    'email_address' => $validated['email_address']
                ]
            );

            $recipientId = $recipient->id;
        }

        $encryptionResult = MessageEncryptionService::encrypt($validated['contents']);
        $password = Str::password();
        $expiryTimestamp = isset($validated['expire_in_hours']) ? (now())->addHours((int) $validated['expire_in_hours']) : null;
        $deleteAfterRead = isset($validated['delete_after_read']) ? $validated['delete_after_read'] : false;

        $message = Message::create([
            'contents' => $encryptionResult,
            'recipient_id' => $recipientId,
            'password' => password_hash($password, null),
            'expires_at' => $expiryTimestamp,
            'delete_after_read' => $deleteAfterRead
        ]);

        $messageUrl = url("/{$message->id}");

        return view('sent', ['decryptionPassword' => $password, 'messageUrl' => $messageUrl]);
    }

    /**
     * Display the form to decrypt the message.
     */
    public function protectedShow(Message $message)
    {
        if ($message->expires_at !== null && now()->gte($message->expires_at)){
            $message->delete();

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
        $validated = $request->validated();

        $message->contents = MessageEncryptionService::decrypt($message->contents);

        if ($message->delete_after_read){
            $message->delete();
        }

        return view('show', ['message' => $message]);
    }
}

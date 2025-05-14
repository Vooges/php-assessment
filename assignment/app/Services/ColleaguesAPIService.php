<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Recipient;
use Illuminate\Support\Facades\Log;

class ColleaguesAPIService
{
    private $endpoint;

    public function __construct(){
        $this->endpoint = env('COLLEAGUES_API_ENDPOINT');
    }

    /**
     * Retrieves colleague information from the API and updates the recipients. Stores colleagues who aren't found in the recipients.
     */
    public function updateColleagues() : void
    {
        $response = Http::get($this->endpoint);

        if ($response->successful()){
            try {
                $recipients = json_decode($response->body());

                foreach ($recipients as $recipient) {
                    Recipient::updateOrCreate(
                        ['email_address' => $recipient->email],
                        [
                            'name' => $recipient->name,
                            'email_address' => $recipient->email
                        ]
                    );
                }
            } catch (Exception $e) {
                Log::error($e->toString());
            }
        }
    }
}
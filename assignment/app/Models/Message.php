<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Recipient;

class Message extends Model
{
    protected static function boot() {
        parent::boot();
    
        static::creating(function ($message) {
            $message->expires_at = now()->addMinutes((int) env('MESSAGE_EXPIRATION_MINUTES'));
        });
    }

    protected $fillable = [
        'contents',
        'recipient_id',
        'password'
    ];
    
    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Recipient;

class Message extends Model
{
    protected $fillable = [
        'contents',
        'recipient_id',
        'password',
        'expires_at',
        'delete_after_read'
    ];
    
    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}

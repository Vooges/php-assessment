<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = [
        'email_address',
        'name'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

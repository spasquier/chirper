<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Chirp extends Model
{
    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gravatarIcon(): string
    {
        $email = $this->user->email;
        $hash = hash('sha256', strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/$hash?s=200&d=identicon";
    }
}

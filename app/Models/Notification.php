<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'sender_name',
        'sender_avatar',
        'badge_icon',
        'badge_color',
        'title',
        'target_name',
        'body',
        'action_url',
        'has_actions',
        'action_decline_label',
        'action_accept_label',
        'is_read',
    ];

    protected $casts = [
        'has_actions' => 'boolean',
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

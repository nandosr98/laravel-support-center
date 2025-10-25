<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelSupportCenter\Traits\MergeModelProperties;

class BaseSupportMessage extends Model
{
    use HasFactory, MergeModelProperties;

    protected $table = 'support_messages';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'is_internal',
        'attachment_path',
        'sent_via',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(BaseSupportTicket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support.models.user'));
    }
}

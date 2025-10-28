<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    BelongsToMany
};
use Illuminate\Support\Str;
use LaravelSupportCenter\Traits\MergeModelProperties;
use Spatie\MediaLibrary\InteractsWithMedia;

class BaseSupportTicket extends Model
{
    use HasFactory, InteractsWithMedia, MergeModelProperties;

    protected $table = 'support_tickets';

    protected $fillable = [
        'uuid',
        'user_id',
        'email',
        'assigned_to',
        'subject',
        'description',
        'status',
        'priority',
        'channel',
        'category_id',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $ticket) {
            $ticket->uuid = $ticket->uuid ?? Str::uuid()->toString();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support-center.models.user'));
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(config('support.models.user'), 'assigned_to');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BaseSupportCategory::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(BaseSupportMessage::class, 'ticket_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BaseSupportStatusLog::class, 'ticket_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('support.media_collection'));
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BaseSupportTag::class, 'support_ticket_tag', 'ticket_id', 'tag_id');
    }
}

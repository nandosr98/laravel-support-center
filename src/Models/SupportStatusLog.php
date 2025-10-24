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

class SupportStatusLog extends Model
{
    use HasFactory;

    protected $table = 'support_status_logs';

    protected $fillable = [
        'ticket_id',
        'changed_by',
        'from_status',
        'to_status',
        'comment',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support.models.user'), 'changed_by');
    }
}

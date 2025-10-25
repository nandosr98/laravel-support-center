<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
};
use LaravelSupportCenter\Traits\MergeModelProperties;

class BaseSupportStatusLog extends Model
{
    use HasFactory, MergeModelProperties;

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
        return $this->hasMany(BaseSupportTicket::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support.models.user'), 'changed_by');
    }
}

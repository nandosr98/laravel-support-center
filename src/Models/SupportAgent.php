<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportAgent extends Model
{
    use HasFactory;

    protected $table = 'support_agents';

    protected $fillable = ['user_id', 'role', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support.models.user'));
    }
}

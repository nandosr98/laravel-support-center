<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SupportTag extends Model
{
    use HasFactory;

    protected $table = 'support_tags';

    protected $fillable = ['name', 'color'];

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(SupportTicket::class, 'support_ticket_tag', 'tag_id', 'ticket_id');
    }
}

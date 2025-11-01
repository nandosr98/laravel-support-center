<?php

namespace LaravelSupportCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelSupportCenter\Traits\MergeModelProperties;

class BaseSupportCategory extends Model
{
    use HasFactory, MergeModelProperties;

    protected $table = 'support_categories';

    protected $fillable = ['name', 'description', 'priority'];

    public function tickets(): HasMany
    {
        return $this->hasMany(BaseSupportTicket::class, 'category_id');
    }
}

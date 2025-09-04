<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = ['name', 'daily_sessions', 'responses_per_session', 'is_default'];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}

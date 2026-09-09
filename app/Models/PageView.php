<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'ip_address',
        'url',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];
}

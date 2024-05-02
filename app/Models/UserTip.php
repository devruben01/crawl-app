<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class UserTip extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'user_tips';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'fi',
        'user_id',
        'blog_id',
        'op',
        'ah',
        'ou',
    ];
}

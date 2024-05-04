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
        'home_name',
        'away_name',
        'score',
        'fi',
        'user_info',
        'bet',
        'tip_id',
        'odds1',
        'odds2',
        'odds3',
        'is_win',
        'is_end',
        'is_run',
    ];
}

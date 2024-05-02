<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Season extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'seasons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'season_name',
        'league_id',
        'standings',
        'rounds',
        'description',
        'round_info',
        'order',
    ];

    protected $casts = [
        'rounds' => 'json',
        'round_info' => 'json',
        'standings' => 'json',
    ];
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}

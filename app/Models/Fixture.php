<?php

namespace App\Models;

use App\Casts\MongoDBDateTimeCast;
use App\Casts\ObjectIdCast;
use App\Contracts\TransformerInterface;
use App\Traits\Transformable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsTo as RelationsBelongsTo;

class Fixture extends Model implements TransformerInterface
{
    use Transformable;

    protected $connection = 'mongodb';
    protected $collection = 'fixtures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'api_id',
        'time',
        'home_id',
        'away_id',
        'status',
        'score_ht',
        'score_ft',
        'league_id',
        'statistics',
        'events',
        'rates',
    ];

    protected $casts = [
        'time' => MongoDBDateTimeCast::class,
        'updated_at' => MongoDBDateTimeCast::class,
        '_id' => ObjectIdCast::class,
    ];

    // Relationship
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class, 'league_id');
    }
    public function odds(): HasMany
    {
        return $this->hasMany(Odd::class);
    }
    public function fixtureData(): RelationsBelongsTo
    {
        return $this->belongsTo(FixtureData::class, '_id', 'fi');
    }
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_id', 'id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_id', 'id');
    }
    // End relationship

    // Get Attribute
    public function getId(): string
    {
        return $this->_id;
    }
}

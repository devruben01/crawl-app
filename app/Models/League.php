<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\HybridRelations;
use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasMany as EloquentHasMany;

class League extends Model
{
    use HasFactory, HybridRelations;
    protected $connection = 'mysql';
    protected  $table = "leagues";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'api_id',
        'name',
        'type',
        'logo',
        'description',
        'country_id',
        'current_season',
        'name_vi',
        'name_en',
        'color',
        'is_main',
    ];

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'league_id');
    }
    public function seasons(): EloquentHasMany
    {
        return $this->hasMany(Season::class);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}

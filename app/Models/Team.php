<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\HybridRelations;

class Team extends Model
{
    use HasFactory, HybridRelations;
    protected $connection = 'mysql';
    protected $table = 'teams';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'api_id',
        'name_vi',
        'flag',
        'name',
        'stadium',
        'description',
        'website',
        'founded',
        'capacity',
        'city',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class);
    }
}

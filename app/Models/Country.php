<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MongoDB\Laravel\Eloquent\HybridRelations;
use MongoDB\Laravel\Relations\HasMany;

class Country extends Model
{
    use HasFactory, HybridRelations;
    protected $connection = 'mysql';
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'area_id',
        'name',
        'flag',
        'name_vi',
    ];

    public function leagues(): HasMany
    {
        return $this->hasMany(League::class);
    }
}

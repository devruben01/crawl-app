<?php

namespace App\Models;

use App\Casts\ObjectIdCast;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FixtureData extends Model
{
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'fixtures_data';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'api_id',
        'fi',
        'h2h',
        'next',
        'previous',
        'standings',
    ];

    protected $casts = [
        '_id' => ObjectIdCast::class,
        'fi' => ObjectIdCast::class,
    ];

    public function fixture(): HasOne
    {
        return $this->hasOne(Fixture::class, '_id', 'fi');
    }

    protected function h2h(): Attribute
    {
        return Attribute::make(
            get: fn (?array $value) => $value
                ? array_map(function ($item) {
                    return $item;
                }, $value)
                : null
        );
    }
}

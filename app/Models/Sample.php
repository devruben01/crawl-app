<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Sample"),
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Sample title"),
 *     @OA\Property(property="description", type="string", example="Sample description"),
 *     @OA\Property(property="image", type="string", example="storage/images/ihqj2nFwLnoqLoXvmsGkHPBJgVxX.png"),
 * )
 */
class Sample extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected $casts = [
        'created_at' => Constants::DATETIME_Y_M_D_H_I_S,
        'updated_at' => Constants::DATETIME_Y_M_D_H_I_S,
    ];
}

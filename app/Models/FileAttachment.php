<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAttachment extends Model
{
    use HasFactory;

    protected $table = 'file_attachments';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'path',
    ];

    protected $casts = [
        'created_at' => Constants::DATETIME_Y_M_D_H_I_S,
        'updated_at' => Constants::DATETIME_Y_M_D_H_I_S,
    ];
}

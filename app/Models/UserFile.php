<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = [
        'user_id',
        'owner_id',
        'original_file_name',
        'original_file_path',
        'signed_file_path',
    ];
}
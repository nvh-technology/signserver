<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fileConfig',
        'keystore',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('userName', 'passcode', 'credentialID');
    }
}

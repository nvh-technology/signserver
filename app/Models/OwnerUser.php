<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OwnerUser extends Model
{
    use HasFactory;

    protected $table = "owner_user";
    protected $fillable = [
        'user_id',
        'owner_id',
        'userName',
        'passcode',
        'credentialID',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function owner()
    {
        return $this->hasOne(Owner::class, 'id', 'owner_id');
    }
}

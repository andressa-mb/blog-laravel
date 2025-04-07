<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = [
        'name'
    ];

    public function users(): HasMany{
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}

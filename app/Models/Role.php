<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permission', 'role_id', 'permission_id');
    }
}

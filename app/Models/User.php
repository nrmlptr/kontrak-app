<?php

namespace App\Models;


use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'unit_kerja',
        'password',
        'permission'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // METHOD RELASI KE TABEL ROLE =========================================================================================
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // METHOD UNTUK  GET ROLE  ==============================================================================================
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }

    // METHOD UNTUK MEMERIKSA PERMISSION  ====================================================================================
    // fungsi untuk cek permission
    // public function hasPermission($permission)
    // {
    //     foreach ($this->roles as $role) {
    //         if ($role->permissions->contains('name', $permission)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // METHOD UNTUK MEMERIKSA PERMISSION  ====================================================================================
    public function hasPermission($permission)
    {
        // Query untuk cek permission user
        return DB::table('role_permission')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            ->join('roles', 'role_permission.role_id', '=', 'roles.id')
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.user_id', $this->id)
            ->where('permissions.name', $permission)
            ->exists();
    }

    // METHOD UNTUK GET SEMUA PERMISSION USER =================================================================================
    public function getPermissions()
    {
        return DB::table('role_permission')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            ->join('roles', 'role_permission.role_id', '=', 'roles.id')
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.user_id', $this->id)
            ->pluck('permissions.name')
            ->toArray();
    }


    // FOR DEBUGGING ============================================================================================================
    // public function hasPermission($permission)
    // {
    //     $permissions = DB::table('role_permission')
    //         ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
    //         ->join('roles', 'role_permission.role_id', '=', 'roles.id')
    //         ->join('role_user', 'roles.id', '=', 'role_user.role_id')
    //         ->where('role_user.user_id', $this->id)
    //         ->where('permissions.name', $permission)
    //         ->exists();

    //     Log::info('Checking permission: ' . $permission);
    //     Log::info('Permission exists: ' . ($permissions ? 'true' : 'false'));

    //     return $permissions;
    // }

    // public function getPermissions()
    // {
    //     $permissions = DB::table('role_permission')
    //         ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
    //         ->join('roles', 'role_permission.role_id', '=', 'roles.id')
    //         ->join('role_user', 'roles.id', '=', 'role_user.role_id')
    //         ->where('role_user.user_id', $this->id)
    //         ->pluck('permissions.name')
    //         ->toArray();

    //     Log::info('User Permissions: ', $permissions);

    //     return $permissions;
    // }

}

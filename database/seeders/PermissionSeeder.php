<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role_admin = Role::updateOrCreate(
            [
                'name'    => 'admin',
            ],
            ['name'    => 'admin']
        );

        $role_staff = Role::updateOrCreate(
            [
                'name'    => 'writer',
            ],
            ['name'    => 'writer']
        );

        $role_kadept = Role::updateOrCreate(
            [
                'name'    => 'kadept',
            ],
            ['name'    => 'kadept']
        );

        $role_kasek = Role::updateOrCreate(
            [
                'name'    => 'kasek',
            ],
            ['name'    => 'kasek']
        );

        $role_kadiv = Role::updateOrCreate(
            [
                'name'    => 'kadiv',
            ],
            ['name'    => 'kadiv']
        );

        $permission  = Permission::updateOrCreate(
            [
                'name' => 'view_input',
            ],
            ['name' => 'view_input']
        );

        $permission2  = Permission::updateOrCreate(
            [
                'name' => 'view_user',
            ],
            ['name' => 'view_user']
        );

        $role_staff->givePermissionTo($permission);
        $role_admin->givePermissionTo($permission);
        $role_admin->givePermissionTo($permission2);

        $userId = Auth::user()->id;


        // $user = User::find(1);
        $user = User::find($userId);

        // $user2 = User::find(3);
        // $user3 = User::find(7);
        // $user4 = User::find(5);
        // $user5 = User::find(6);
        // $user6 = User::find(8);
        // $user7 = User::find(4);
        $userPermission = Auth::user()->permission;


        //perintah untuk tambah role admin ke user yang dipanggil
        $user->assignRole($userPermission);
        // $user2->assignRole('writer');
        // $user->assignRole('admin');

        // $user3->assignRole('kadept');
        // $user4->assignRole('admin');
        // $user5->assignRole('writer');
        // $user6->assignRole('kadiv');
        // $user7->assignRole('kasek');

        
       
    }
}

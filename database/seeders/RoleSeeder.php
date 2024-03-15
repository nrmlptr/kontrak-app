<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        //
        Role::updateOrCreate(
            [
                'name'    => 'admin',
            ],
            ['name'    => 'admin']
        );

        Role::updateOrCreate(
            [
                'name'    => 'writer',
            ],
            ['name'    => 'writer']
        );

        Role::updateOrCreate(
            [
                'name'    => 'guest',
            ],
            ['name'    => 'kadept']
        );
        Role::updateOrCreate(
            [
                'name'    => 'kasek',
            ],
            ['name'    => 'kasek']
        );

        Role::updateOrCreate(
            [
                'name'    => 'kadiv',
            ],
            ['name'    => 'kadiv']
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Seeder;
use Str;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        Permission::updatePermissions();
        
        $permission = Permission::pluck('id')->all();
        
        $role = Role::create([
            'id' => Str::uuid(),
            'name' => 'Developer',
        ]);

        $role->modifiedSyncPermissions($permission);
        
        $permission = Permission::where("name","like", "%home")->pluck('id');

        $role = Role::create([
            'id' => Str::uuid(),
            'name' => 'Guest',
        ]);

        $role->modifiedSyncPermissions($permission);

    }
}
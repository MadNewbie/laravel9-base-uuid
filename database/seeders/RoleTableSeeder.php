<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        Permission::updatePermissions();
        
        $permission = Permission::pluck('id','id')->all();
        
        $role = Role::create([
            'name' => 'Developer',
        ]);

        $role->syncPermissions($permission);
        
        $permission = Permission::where("name","like", "%home")->pluck('id','id');

        $role = Role::create([
            'name' => 'Guest',
        ]);

        $role->syncPermissions($permission);

    }
}
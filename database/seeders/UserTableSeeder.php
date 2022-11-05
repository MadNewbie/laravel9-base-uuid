<?php

namespace Database\Seeders;

use App\Lookups\User\User\UserLookup;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Str;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'id' => Str::uuid(),
            'name' => 'Developer',
            'username' => 'developer',
            'email' => 'developer@this.app',
            'password' => bcrypt('developer'),
            'type_status' => UserLookup::TYPE_STATUS_ACTIVE,
        ]);

        $role = Role::where(['name' => 'Developer'])->first();

        if($role){
            $user->modifiedSyncRole([$role->id]);
        }
    }
}
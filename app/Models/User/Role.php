<?php
namespace App\Models\User;

use App\Base\Components\HelperModel;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HelperModel;
    protected $table = 'roles';

    public static function updateDeveloperRole()
    {
        $permissions = Permission::select(['id'])->get();
        $roleDeveloper = Role::where(['name' => 'Developer'])->first();
        $permissionsIds = [];
        
        foreach($permissions as $permission){
            $permissionsIds[] = $permission->id;
        }

        if($roleDeveloper){
            $roleDeveloper->syncPermissions($permissionsIds);
        }
    }
}
<?php
namespace App\Models\User;

use App\Base\Components\HelperModel;
use App\Base\Components\Uuid;
use Spatie\Permission\Models\Role as BaseRole;
use DB;

class Role extends BaseRole
{
    use HelperModel, Uuid;
    protected $table = 'roles';

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public static function updateDeveloperRole()
    {
        $permissions = Permission::select(['id'])->get();
        $roleDeveloper = Role::where(['name' => 'Developer'])->first();
        $permissionsIds = [];
        
        foreach($permissions as $permission){
            $permissionsIds[] = $permission->id;
        }

        if($roleDeveloper){
            $roleDeveloper->modifiedSyncPermissions($permissionsIds);
        }
    }

    public function modifiedSyncPermissions($permissions)
    {
        $roleId = $this->id;
        $res = true;

        $rolePermissionTableName = config("permission.table_names.role_has_permissions");
        $roleIdColumnName = config("permission.column_names.role_pivot_key")?:"role_id";
        $permissionIdColumnName = config("permission.column_names.permission_pivot_key")?:"permission_id";

        DB::beginTransaction();
        if(DB::table($rolePermissionTableName)->where($roleIdColumnName, "=", $roleId)->count() != 0){
            $res &= DB::table($rolePermissionTableName)->where($roleIdColumnName, "=", $roleId)->delete();
        }

        foreach($permissions as $permission){
            $res &= DB::table($rolePermissionTableName)
                ->insert([
                    $roleIdColumnName => $roleId,
                    $permissionIdColumnName => $permission
                ]);
        }
        $res ? DB::commit() : DB::rollback();
    }
}
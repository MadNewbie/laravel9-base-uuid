<?php
namespace App\Models\User;

use App\Base\Components\HelperModel;
use App\Base\Components\Uuid;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission as BasePermission;
use Str;

class Permission extends BasePermission
{
    use HelperModel, Uuid;
    protected $table = 'permissions';

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'guard_name',
    ];

    public static function updatePermissions()
    {
        $routes = Route::getRoutes();
        $routeList = [];
        
        foreach($routes as $value) {
            $route = $value->getAction();
            if(isset($route['as']) && preg_match("/backyard/",$route['as'])){
                $routeList[] = $route['as'];
            }
        }
        // dd($routeList);

        $ids = [];

        foreach($routeList as $value) {
            $permission = Permission::where('name','=',$value)->first();
            if ($permission) {
                $ids[]=$permission['id'];
            } else {
                $id = Str::uuid();
                $permission = Permission::create(['name' => $value, 'id'=>$id]);
                $ids[]=$id;
            }
        }

        $permissions = Permission::whereNotIn('id',$ids)->get();
        
        foreach($permissions as $permission){
            $permission->delete();    
        }
    }
}
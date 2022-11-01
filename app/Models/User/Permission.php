<?php
namespace App\Models\User;

use App\Base\Components\HelperModel;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use HelperModel;
    protected $table = 'permissions';

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
            $permission = BasePermission::where(['name' => $value])->first();
            if ($permission) {
                $ids[]=$permission['id'];
            } else {
                $permission = BasePermission::create(['name' => $value]);
                $ids[]=$permission['id'];
            }
        }

        $permissions = BasePermission::whereNotIn('id',$ids)->get();

        foreach($permissions as $permission){
            $permission->delete();    
        }
    }
}
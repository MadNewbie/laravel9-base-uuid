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
            $permission = BasePermission::where('name','=',$value)->first();
            if ($permission) {
                $ids[]=$permission['id'];
            } else {
                $id = Str::uuid();
                $permission = BasePermission::create(['name' => $value, 'id'=>$id]);
                $ids[]=$id;
            }
        }

        $permissions = BasePermission::whereNotIn('id',$ids)->get();
        
        foreach($permissions as $permission){
            $permission->delete();    
        }
    }
}
<?php

namespace App\Http\Controllers\Backyard\User;

use App\Base\BaseController;
use App\Libraries\Mad\Helper;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends BaseController
{
    public static $partName = 'backyard';
    public static $moduleName = 'user';
    public static $modelName = 'role';

    public function __construct()
    {
        $this->middleware('is_verify_email');
        $this->middleware('permission:' . self::getRoutePrefix('index'),['only' => 'index', 'indexData']);
        $this->middleware('permission:' . self::getRoutePrefix('show'),['only' => 'show']);
        $this->middleware('permission:' . self::getRoutePrefix('create'),['only' => 'create']);
        $this->middleware('permission:' . self::getRoutePrefix('store'),['only' => 'store']);
        $this->middleware('permission:' . self::getRoutePrefix('edit'),['only' => 'edit']);
        $this->middleware('permission:' . self::getRoutePrefix('update'),['only' => 'update']);
        $this->middleware('permission:' . self::getRoutePrefix('destroy'),['only' => 'destroy']);
    }

    public function index()
    {
        Permission::updatePermissions();
        Role::updateDeveloperRole();
        return self::makeView('index');
    }

    public function indexData(Request $request)
    {
        $search = $request->get('search')['value'];

        $roleTableName = Role::getTableName();

        $q = Role::query()
            ->select([
                "{$roleTableName}.name",
                "{$roleTableName}.id",
            ]);

        Helper::fluentMultiSearch($q, $search, [
            "{$roleTableName}.name",
        ]);

        $res = DataTables::of($q)
            ->editColumn('name', function(Role $v){
                return '<a href="' . route(self::getRoutePrefix("show"),$v->id). '">' . $v->name . '</a>';
            })
            ->editColumn('_menu', function(Role $model){
                return self::makeView('index-menu', compact('model'))->render();
            })
            ->rawColumns(['name','_menu'])
            ->make(true);

        return $res;
    }

    private function _save(Request $request, $id = null)
    {
        $rules = [
            'permissions' => 'required',
        ];

        if(!$id){
            $rules['name'] = 'required | unique:roles,name';
        }

        $this->validate($request, $rules);

        $res = true;
        $input = $request->all();
        $model = $id ? Role::find($id) : new Role();
        $model->fill($input);
        $res &= $model->save();
        $model->syncPermissions($input['permissions']);

        return $res ? redirect()->route(self::getRoutePrefix('index'))->with('success', 'Data berhasil tersimpan') : redirect()->route(self::getRoutePrefix('index'))->with('error','Data gagal tersimpan');
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return self::makeView('create', compact('permissions'));
    }

    public function store(Request $request)
    {
        return $this->_save($request);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::orderBy('name','asc')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck("role_has_permissions.permission_id", "role_has_permissions.permission_id")
            ->all();

        return self::makeView('edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        return $this->_save($request, $id);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return self::makeView('show', compact('role', 'rolePermissions'));
    }

    public function destroy($id)
    {
        $model = Role::find($id);
        $model->syncPermissions([]);
        return $model->delete() ? "1" : "Data tidak dapat dihapus";
    }
}
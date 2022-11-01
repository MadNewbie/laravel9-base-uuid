<?php

namespace App\Http\Controllers\Backyard\User;

use App\Base\BaseController;
use App\Libraries\Mad\Helper;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends BaseController
{
    public static $partName = 'backyard';
    public static $moduleName = 'user';
    public static $modelName = 'user';

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
        return self::makeView('index');
    }

    public function indexData(Request $request)
    {
        $search = $request->get('search')['value'];

        $userTableName = User::getTableName();

        $q = User::query()
            ->select([
                "{$userTableName}.name",
                "{$userTableName}.id"
            ]);
        
        Helper::fluentMultiSearch($q,$search,[
            "{$userTableName}.name",
        ]);

        $res = DataTables::of($q)
            ->editColumn('name', function(User $v){
                return '<a href="' . route(self::getRoutePrefix("show"),$v->id). '">' . $v->name . '</a>';
            })
            ->editColumn('_menu', function(User $model){
                return self::makeView('index-menu', compact('model'))->render();
            })
            ->rawColumns(['name', '_menu'])
            ->make(true);

        return $res;
    }

    private function _save(Request $request, $id = null)
    {
        $rules = [
            'roles' => 'required',
            'name' => 'required',
        ];

        if(!$id){
            $rules['password'] = 'required|confirmed|min:6';
        }
        $rules['username'] = !$id ? 'required|unique:users,username' : 'required';
        $rules['email'] = !$id ? 'required|email|unique:users,email' : 'required|email';
        $this->validate($request,$rules);
        $res = true;
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $model = $id ? User::find($id) : new User();
        $model->fill($input);
        DB::beginTransaction();
        $res &= $model->save();
        $model->assignRole($input['roles']);
        $res ? DB::commit() : DB::rollback();

        return $res ? redirect()->route(self::getRoutePrefix('index'))->with('success','Data berhasil tersimpan') : redirect()->route(self::getRoutePrefix('index'))->with('error','Data gagal tersimpan');
    }

    public function store(Request $request)
    {
        return $this->_save($request);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        if(!Auth::user()->isDeveloper()){
            unset($roles['Developer']);
        }
        return self::makeView('edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        return $this->_save($request, $id);
    }

    public function show($id)
    {
        $user = User::find($id);
        return self::makeView('show', compact('user'));
    }

    public function destroy($id)
    {
        $model = User::find($id);
        $model->assignRole([]);
        return $model->delete() ? '1' : 'Data tidak bisa dihapus';
    }
}
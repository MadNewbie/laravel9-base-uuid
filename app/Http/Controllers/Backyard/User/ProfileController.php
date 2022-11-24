<?php
namespace App\Http\Controllers\Backyard\User;

use App\Models\User\User;
use App\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends BaseController
{
    public static $partName = 'backyard';
    public static $moduleName = 'user';
    public static $modelName = 'profile';
    public static $mediaPath = 'storage/profpic';

    public function __construct()
    {
        $this->middleware('is_verify_email');
        $this->middleware('permission:' . self::getRoutePrefix('show'),['only' => 'show']);
        $this->middleware('permission:' . self::getRoutePrefix('edit'),['only' => 'edit']);
        $this->middleware('permission:' . self::getRoutePrefix('update'),['only' => 'update']);
    }

    public function show($id)
    {
        $user = User::find($id);
        return self::makeView('show', compact('user'));
    }

    public function edit($id)
    {
        $model = User::find($id);
        return self::makeView('edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        return $this->_save($request, $id);
    }

    private function _save(Request $request, $id = null)
    {
        $rules = [
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
        if(!isset($input['password']) || (strcmp($input['password'],"") == 0)){
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        $model = $id ? User::find($id) : new User();
        $model->fill($input);
        DB::beginTransaction();
        if(isset($input['photo'])){
            if(isset($model->photo_filename)){
                $existingPhoto = sprintf("%s/%s",public_path(self::$mediaPath), $model->photo_filename);
                if(file_exists($existingPhoto)){
                    unlink($existingPhoto);
                }
            }
            preg_match('/data:image\/(?<mime>.*?)\;/',$input['photo'],$groups);
            $mimetype = $groups['mime'];
            $name = sprintf("img-%s", date('YmdHis'));
            $filename = sprintf("%s/%s.%s",public_path(self::$mediaPath),$name,$mimetype);
            $img = Image::make($input['photo'])->encode($mimetype, 100)->save($filename);
            $model->photo_filename = $img->basename;
        }
        $res &= $model->save();
        $res ? DB::commit() : DB::rollback();

        return $res ? redirect()->route('backyard.user.home')->with('success','Data berhasil tersimpan') : redirect()->route(self::getRoutePrefix('index'))->with('error','Data gagal tersimpan');
    }
}
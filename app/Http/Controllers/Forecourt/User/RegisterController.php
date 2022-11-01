<?php
namespace App\Http\Controllers\Forecourt\User;

use Hash;
use App\Models\User\Role;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Lookups\User\User\UserLookup;
use App\Models\User\User;
use App\Models\User\UserVerifyToken;
use DB;
use Str;
use Mail;

class RegisterController extends BaseController
{
    public static $partName = 'forecourt';
    public static $moduleName = 'user';

    public function showForm()
    {
        return self::makeView('register');
    }

    public function registerUser(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ];

        $this->validate($request,$rules);
        $res = true;

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['type_status'] = UserLookup::TYPE_STATUS_NOT_YET;

        $role = Role::where('name','=','Guest')->first();
        $model = new User();
        $model->fill($input);
        DB::beginTransaction();
        $res &= $model->save();
        $token = Str::random(64);
        $inputVerifyToken = [
            'user_id' => $model->id,
            'token' => $token,
        ];

        Mail::send('forecourt.mail.register', ['token' => $token], function($message) use($model){

            $message->to($model->email);

            $message->subject('Email Verification Mail');

        });
        
        $userVerifyToken = new UserVerifyToken();
        $userVerifyToken->fill($inputVerifyToken);
        $res &= $userVerifyToken->save();
        $model->assignRole($role->name);
        $res ? DB::commit() : DB::rollback();

        return $res ? redirect()->route('login')->with('success','Akun berhasil terdaftar. Silahkan cek kotak masuk email yang telah didaftarkan') : redirect()->route('register')->with('error','Akun gagal terdaftar');
    }
}
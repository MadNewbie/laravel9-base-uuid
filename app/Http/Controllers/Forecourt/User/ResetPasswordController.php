<?php
namespace App\Http\Controllers\Forecourt\User;

use App\Models\User\User;
use App\Base\BaseController;
use App\Models\User\UserResetPasswordToken;
use Illuminate\Http\Request;
use Str;
use DB;
use Mail;
use Hash;

class ResetPasswordController extends BaseController
{
    public static $partName = 'forecourt';
    public static $moduleName = 'user';

    public function showRequestResetPasswordForm()
    {
        return self::makeView('request_reset');
    }

    public function postRequestResetPassword(Request $request)
    {
        $input = $request->all();
        
        $user = User::where('email','=',$input['email'])->first();
        if(!$user){
            return redirect()->route('request.reset.password')->with('error','Email belum terdaftar dalam daftar akun kami. Mohon maaf');
        }
        $token = Str::random(64);
        $inputToken = [
            'user_id' => $user->id,
            'token' => $token,
        ];
        $res = true;
        $userResetPasswordToken = new UserResetPasswordToken();
        $userResetPasswordToken->fill($inputToken);
        DB::beginTransaction();
        $res &= $userResetPasswordToken->save();
        Mail::send('forecourt.mail.reset_password', ['token' => $token], function($message) use($user){

            $message->to($user->email);

            $message->subject('Email Reset Password Request Mail');

        });

        $res ? DB::commit() : DB::rollback();
        return $res ? redirect()->route('login')->with('success','Permintaan reset password disetujui. Silahkan cek kotak masuk email yang telah didaftarkan') : redirect()->route('register')->with('error','Permintaan reset password ditolak. Mohon maaf');
    }

    public function showResetPasswordForm($token)
    {
        return self::makeView('reset_password',compact('token'));
    }

    public function postResetPassword(Request $request)
    {
        $input = $request->all();

        $rules = [
            'password' => 'required|confirmed|min:6',
        ];

        $this->validate($request, $rules);

        $userResetPasswordToken = UserResetPasswordToken::where('token', '=', $input['reset-token'])->first();
        $user = $userResetPasswordToken->user;
        if(Hash::check($input['password'], $user->password)){
            return redirect()->route('reset.password',$input['reset-token'])->with('error','Password baru tidak boleh sama dengan password lama.');
        }
        $res = true;
        DB::beginTransaction();
        $user->password = Hash::make($input['password']);
        $userResetPasswordTokenTableName = UserResetPasswordToken::getTableName();
        DB::table($userResetPasswordTokenTableName)->where('user_id',"=",$user->id)->delete();
        $res &= $user->save();
        $res ? DB::commit() : DB::rollback();

        return $res ? redirect()->route('login')->with('success','Password berhasil diubah') : redirect()->route('request.reset.password')->with('error','Password gagal diubah');
    }
}
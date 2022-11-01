<?php
namespace App\Http\Controllers\Forecourt\User;

use App\Models\User\User;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Models\User\UserVerifyToken;
use Illuminate\Support\Facades\Mail;
use App\Lookups\User\User\UserLookup;

class VerificationController extends BaseController
{
    public static $partName = 'forecourt';
    public static $moduleName = 'user';

    public function verification($token)
    {
        $res = true;
        $userVerify = UserVerifyToken::where('token','=',$token)->first();
        $user = $userVerify->user;
        $user->type_status = UserLookup::TYPE_STATUS_ACTIVE;
        $user->email_verified_at = date_create()->format('Y-m-d H:i:s');
        $res &= $user->save();
        return $res ? redirect()->route('login')->with('success', 'Akun berhasil diaktifasi') : redirect()->route('login')->with('error', 'Akun gagal diaktifasi');
    }

    public function requestVerification()
    {
        return self::makeView('verification');
    }

    public function postRequestVerification(Request $request)
    {
        $input = $request->all();
        $user = User::where('email','=',$input['email'])->first();
        if(!$user){
            return redirect()->route('request.verification')->with('error','Email belum terdaftar dalam daftar akun kami. Mohon maaf');
        }
        $userVerify = UserVerifyToken::where('user_id','=',$user->id)->first();
        $token = $userVerify->token;
        Mail::send('forecourt.mail.register', ['token' => $token], function($message) use($user){

            $message->to($user->email);

            $message->subject('Email Verification Mail');

        });
        return redirect()->route('request.verification')->with('success','Email verifikasi telah kami kirimkan, Silahkan anda mengecek kotak masuk email anda. Terima Kasih');
    }
}
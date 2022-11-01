<?php

namespace App\Http\Middleware;

use App\Lookups\User\User\UserLookup;
use Closure;
use Illuminate\Http\Request;
use Auth;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->type_status != UserLookup::TYPE_STATUS_ACTIVE) {
            auth()->logout();
            return redirect()->route('email.verification')
            ->with('error', 'Perlu verifikasi akun, kode verifikasi telah kami kirim ke email yang telah terdaftar. Tolong cek email anda, Terima Kasih');
        }
        return $next($request);
    }
}

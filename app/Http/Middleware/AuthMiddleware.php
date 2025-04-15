<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('user')) {
            return redirect('/login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
        }

        $loginTime = session('login-time');

        if ($loginTime && now()->diffInMinutes(Carbon::parse($loginTime)) >= 5) {
            $token = session('user.access_token');

            try {
                Http::withToken($token)->post('https://bepm.hanatekindo.com/api/v1/auth/logout');
            } catch (\Exception $e) {
                // log error optionally
                return redirect('/login')->withErrors(['error' => 'Sesi telah berakhir, silakan login kembali']);
            }

            session()->forget(['user', 'login-time']);
            session()->flush();

            return redirect('/login')->withErrors(['error' => 'Sesi telah berakhir, silakan login kembali']);
        }

        // if (session('login-time') && now()->diffInMinutes(session('login-time')) >= 5) {
        //     $token = session('user.access_token');

        //     try{
        //         Http::withToken($token)->post('https://bepm.hanatekindo.com/api/v1/auth/logout');
        //     }catch (\Exception $e){
        //         return redirect('/login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
        //     }

        //     session()->forget(['user']);
        //     session()->forget(['login-time']);
        //     session()->flush();

        //     return redirect('/login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
        // }

        return $next($request);
    }
}


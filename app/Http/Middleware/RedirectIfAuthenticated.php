<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Nếu guard là 'admin' và request đang cố gắng truy cập trang chủ ('/'),
                // thì cho phép request đi tiếp thay vì chuyển hướng.
                if ($guard == 'admin' && $request->is('/')) { // Hoặc $request->is(RouteServiceProvider::HOME)
                    return $next($request);
                }

                // Ngược lại, thực hiện chuyển hướng như bình thường
                $url = $guard == 'admin' ? route('admin.dashboard') : route('user.auth.indexUser');
                return redirect($url);
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        $data = explode('/', $path);
        if (count($data) > 0) {
            $menu = DB::table('menu')->where('alias', '=', $data[0])->first();
            if ($menu != null) {
                $menu_id = $menu->id;
                $user_role_id = Auth::user()->role;
                $access = DB::table('menu_role')->where('user_role_id', '=', $user_role_id)
                    ->where('menu_id', '=', $menu_id)->first();
                if ($access != null) {
                    if (count($data) == 1 && $access->read_access == 'X') {
                        return $next($request);
                    } else if (count($data) > 1) {
                        $action = $data[1];
                        if ($action == 'create' && $access->create_access == 'X') {
                            return $next($request);
                        } else if ($action == 'edit' && $access->update_access == 'X') {
                            return $next($request);
                        } else if ($action == 'destroy' && $access->delete_access == 'X') {
                            return $next($request);
                        } else {
                            return redirect('noauth');
                        }
                    } else {
                        return redirect('noauth');
                    }
                } else {
                    //kalau tidak ada akses  matiin
                    return redirect('noauth');
                }
            } else {
                return $next($request);
                //kalau menu belum dimaintain semua bisa buka
            }
        } else {
            return $next($request);
            //kalau path nya tidak ada semua  bisa buka
        }
    }
}

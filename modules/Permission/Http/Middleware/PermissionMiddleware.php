<?php

namespace Modules\Permission\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        Auth::user()->syncRoles(['writer', 'moderator']);
//        Auth::user()->syncPermissions(['users.store']);

        if (!Auth::user()->is_superuser && !Auth::user()->can(Route::currentRouteName())) {
            abort(403, 'Forbidden');
        }


//        dump([
//            'Auth::user()->can(\'users.index\')' => Auth::user()->can('users.index'),
//            'Route::currentRouteName()' => Route::currentRouteName(),
//            'Route::currentRouteAction()' => Route::currentRouteAction(),
//            'Auth::user()->permissions' => Auth::user()->permissions,
////            'Auth::user()->getAllPermissions()' => Auth::user()->getAllPermissions(),
//            'Auth::user()->getRoleNames()' => Auth::user()->getRoleNames(),
//        ]);

        return $next($request);
    }
}

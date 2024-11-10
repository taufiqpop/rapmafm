<?php

namespace App\Http\Middleware;

use App\Models\Action;
use App\Models\MenuRole;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class RbacCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $slug, $action_id = 1)
    {
        $role_id = session('role_id');
        if (empty($role_id)) {
            return redirect()->route('check-access');
        }
        $check = $this->rbacCheck($slug, $action_id);
        if ($check == false)
            abort(403, 'Access Forbidden');

        $actions = Action::all();
        $permissions = [];
        foreach ($actions as $action) {
            $permissions[$action->name] = $this->rbacCheck($slug, $action->id);
        }
        View::share('permissions', $permissions);

        $roles = Role::all();
        $role_id = session('role_id');
        $access_roles = [];
        foreach ($roles as $role) {
            $access_roles[$role->slug_name] = $role->id == $role_id ? true : false;
        }
        View::share('access_roles', $access_roles);
        return $next($request);
    }

    function rbacCheck($slug, $action_id)
    {
        $role_id = session('role_id');
        $check = MenuRole::where([
            'role_id' => $role_id,
            'action_id' => $action_id,
            'is_active' => 1,
        ])->whereHas('menu', function ($query) use ($slug) {
            $query->where('slug_name', $slug);
        })->first();

        if (empty($check)) {
            return false;
        }

        return true;
    }
}

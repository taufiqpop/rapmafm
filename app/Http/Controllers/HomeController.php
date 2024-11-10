<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // RBAC Check
    public function rbacCheck(Request $request)
    {
        $user = User::with('roles')->find(Auth::id());

        if (count($user->roles) == 1) {
            $request->session()->put('role_id', $user->roles[0]->id);
            $request->session()->put('role_name', $user->roles[0]->name);
            $request->session()->put('multi_role', false);
            return redirect()->route('dashboard');
        }

        $data = [
            'user' => $user,
        ];

        return view('auth.roles', $data);
    }

    // Choose Role
    public function chooseRole(Request $request)
    {
        $role_id = Crypt::decrypt($request->role_id);
        $role = Role::find($role_id);

        $request->session()->put('role_id', $role->id);
        $request->session()->put('role_name', $role->name);
        $request->session()->put('multi_role', true);

        return redirect()->route('dashboard');
    }

    // Load Menu
    public function loadMenu(Request $request)
    {
        try {
            $role_id = session('role_id');
            $menu = $this->getMenu($role_id);

            return response()->json(['data' => $menu], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage()], 400);
        }
    }

    // Get Menu
    public function getMenu($role_id, $parent_id = null)
    {
        $menus = Menu::select(DB::raw('id, parent_id, name, menu_order, link, icon'))
            ->where('parent_id', $parent_id)
            ->whereHas('roles', function ($query) use ($role_id) {
                $query->where('menu_roles.role_id', $role_id);
                $query->where('menu_roles.action_id', 1);
                $query->where('menu_roles.is_active', 1);
            })
            ->orderBy('menu_order', 'asc')
            ->get();

        foreach ($menus as $menu) {
            $menu->encode_id = Crypt::encryptString($menu->id);
            $menu->child = $this->getMenu($role_id, $menu->id);
            unset($menu->id);
        }

        return $menus;
    }
}

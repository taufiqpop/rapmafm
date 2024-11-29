<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Role;
use App\Models\Menu;
use App\Models\MenuRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OtoritasController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Otoritas'
        ];

        return view('contents.administrator.otoritas.list', $data);
    }

    public function data(Request $request)
    {
        $list = Role::select('id', 'name', 'slug_name', 'created_at')
            ->where('is_active', 1);

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'slug_name' => Str::snake($request->name),
                'is_active' => 1,
            ]);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('roles', 'name')->ignore($request->id)]
        ]);

        try {
            $role = Role::find($request->id);

            $role->name = $request->name;
            $role->slug_name = Str::snake($request->name);

            if ($role->isDirty()) {
                $role->save();
            }

            if ($role->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $role = Role::find($request->id);
            $role->delete();

            if ($role->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Form Permission
    public function formPermission(Request $request, $slug = null)
    {
        $role = Role::where('slug_name', $slug)->first();
        $actions = Action::all();
        $menus = $this->getMenu($role->id);

        $data = [
            'title' => 'Pengaturan Hak Akses',
            'menus' => $menus,
            'actions' => $actions,
            'role' => $role,
        ];

        return view('contents.administrator.otoritas.permissions', $data);
    }

    // Submit Permission
    public function submitPermission(Request $request)
    {
        try {
            $role_id = $request->role_id;

            $actions = Action::all();
            $menus = Menu::all();
            $role = Role::find($role_id);

            $affected = 0;

            foreach ($menus as $menu) {
                foreach ($actions as $action) {
                    $request_name = $menu->id . '_' . $role->id . '_' . $action->id;

                    $value = $request->$request_name;

                    $active = 1;
                    if (empty($value)) {
                        $active = 0;
                    }

                    $update = MenuRole::updateOrCreate([
                        'menu_id' => $menu->id,
                        'role_id' => $role->id,
                        'action_id' => $action->id
                    ], [
                        'is_active' => $active,
                    ]);

                    if (!empty($update)) {
                        $affected += 1;
                    }
                }
            }

            return redirect()->route('otoritas')->with('affected', $affected);
        } catch (\Exception $e) {
            return redirect()->route('otoritas')->with('error', $e->getMessage());
        }
    }

    // Get Menu
    public function getMenu($role_id, $parent_id = null)
    {
        $menus = Menu::select(DB::raw('id, parent_id, name'))
            ->where('parent_id', $parent_id)
            ->with(['permissions' => function ($query) use ($role_id) {
                $query->select(DB::raw('menu_id, role_id, GROUP_CONCAT(action_id) as action'));
                $query->where('role_id', $role_id);
                $query->where('is_active', 1);
                $query->groupBy('menu_id');
                $query->groupBy('role_id');
                $query->orderBy('action_id');
            }])
            ->get();

        foreach ($menus as $menu) {
            $menu->child = $this->getMenu($role_id, $menu->id);
            if (!empty($menu->permissions)) {
                $actions = explode(',', $menu->permissions->action);

                $menu->actions = array_map(function ($item) {
                    return (int) $item;
                }, $actions);
            } else {
                $menu->actions = [];
            }
            unset($menu->permissions);
        }

        return $menus;
    }
}

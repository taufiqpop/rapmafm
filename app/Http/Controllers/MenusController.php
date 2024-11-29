<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MenusController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Manajemen Menu'
        ];

        return view('contents.administrator.menu.list', $data);
    }

    public function data(Request $request)
    {
        $list = Menu::select(DB::raw('id, parent_id, name, slug_name, icon, link, created_at'))->with('parent');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('menu_type', function ($row) {
                if (empty($row->parent_id)) return 'main';

                return 'child';
            })
            ->addColumn('full_link', function ($row) {
                if (empty($row->link)) return '-';
                return url($row->link);
            })
            ->make();
    }

    public function getMainMenu()
    {
        $list = Menu::select(DB::raw('id, name as text'))->where('parent_id', null)->get();

        return response()->json(['data' => $list]);
    }

    // Create
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'menu_type' => 'required',
            'link' => 'required_if:menu_type,child',
            'icon' => 'required_if:menu_type,main'
        ]);

        try {
            $menu_type = $request->menu_type;
            $slug_name = Str::snake($request->name);

            $menu_order = Menu::all();

            switch ($menu_type) {
                case 'main':
                    $menu = Menu::create([
                        'name' => $request->name,
                        'slug_name' => $slug_name,
                        'link' => $request->link,
                        'icon' => $request->icon,
                        'is_active' => 1,
                        'menu_order' => $menu_order->count() + 1
                    ]);
                    break;

                case 'child':
                    $parent_id = $request->parent_id;
                    $parent = Menu::find($parent_id);
                    $menu = Menu::create([
                        'parent_id' => $parent_id,
                        'name' => $request->name,
                        'slug_name' => $slug_name,
                        'link' => $request->link,
                        'is_active' => 1,
                        'menu_order' => $parent->menu_order
                    ]);
                    break;

                default:
                    $menu = null;
                    break;
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'menu_type' => 'required',
            'link' => 'required_if:menu_type,child',
            'icon' => 'required_if:menu_type,main'
        ]);

        try {
            $menu_id = $request->id;
            $menu_type = $request->menu_type;

            switch ($menu_type) {
                case 'main':
                    $menu = Menu::find($menu_id);

                    $menu->name = $request->name;
                    $menu->link = $request->link;
                    $menu->icon = $request->icon;

                    if ($menu->isDirty()) {
                        $menu->save();
                    }
                    break;

                case 'child':
                    $parent_id = $request->parent_id;
                    $menu = Menu::find($menu_id);

                    $menu->name = $request->name;
                    $menu->link = $request->link;

                    if ($menu->isDirty()) {
                        $menu->save();
                    }
                    break;

                default:
                    $menu = null;
                    break;
            }

            if ($menu->wasChanged()) {
                return response()->json(['status' => true], 200);
            }

            return response()->json(['status' => false], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        $menu_id = $request->id;

        try {
            $menu = Menu::find($menu_id);

            $menu->delete();

            if ($menu->trashed()) {
                return response()->json(['status' => true], 200);
            }
            return response()->json(['status' => false], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}

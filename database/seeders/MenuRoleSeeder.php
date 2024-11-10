<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_roles')->truncate();
        $menus = Menu::all();
        $actions = Action::all();
        $roles = Role::all();

        foreach ($roles as $role) {
            if ($role->id == 1) {
                foreach ($menus as $menu) {
                    foreach ($actions as $action) {
                        DB::table('menu_roles')->insert([
                            'role_id' => $role->id,
                            'menu_id' => $menu->id,
                            'action_id' => $action->id,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            } else {
                DB::table('menu_roles')->insert([
                    'role_id' => $role->id,
                    'menu_id' => 1,
                    'action_id' => 1,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }
}

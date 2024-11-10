<?php

namespace Database\Seeders;

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->truncate();
        $admin = User::find(1);
        $users = User::where('id', '<>', 1)->get();

        $roles = Role::all();

        foreach ($roles as $role) {
            $admin->roles()->attach($role->id);
        }

        foreach ($users as $user) {
            $user->roles()->attach(2);
        }
    }
}

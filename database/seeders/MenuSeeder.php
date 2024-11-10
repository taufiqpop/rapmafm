<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        DB::table('menus')->insert([
            'name' => 'Beranda',
            'slug_name' => 'beranda',
            'menu_order' => 1,
            'link' => 'dashboard',
            'icon' => 'bx bx-home-circle',
            'is_active' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('menus')->insert([
            'name' => 'Pengguna',
            'slug_name' => 'pengguna',
            'menu_order' => 2,
            'link' => 'users',
            'icon' => 'bx bx-user',
            'is_active' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('menus')->insert([
            'name' => 'Manajemen Menu',
            'slug_name' => 'manajemen_menu',
            'menu_order' => 3,
            'link' => 'manajemen-menu',
            'icon' => 'bx bx-food-menu',
            'is_active' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('menus')->insert([
            'name' => 'Otoritas',
            'slug_name' => 'otoritas',
            'menu_order' => 4,
            'link' => 'otoritas',
            'icon' => 'bx bx-check-shield',
            'is_active' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}

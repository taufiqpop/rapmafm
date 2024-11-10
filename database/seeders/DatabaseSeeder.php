<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(MenuRoleSeeder::class);
    }
}

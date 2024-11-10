<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $arr = ['administrator', 'user'];

        foreach ($arr as $key => $value) {
            DB::table('roles')->insert([
                'name' => $value,
                'slug_name' => Str::snake($value),
                'is_active' => 1,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}

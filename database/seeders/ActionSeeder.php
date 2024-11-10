<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->truncate();
        $arr = ['view', 'create', 'update', 'delete', 'download'];

        foreach ($arr as $key => $value) {
            DB::table('actions')->insert([
                'name' => $value,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}

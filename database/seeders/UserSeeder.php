<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Main Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => Carbon::now()
        ]);

        factory(User::class, 5)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\BreakTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
        ->has(
            UserAttendance::factory()
                ->count(40)
                ->has(BreakTime::factory()->count(1), 'breakTime'))
        ->create([
            'name'  => '鈴木 太郎',
            'email' => 'user@example.com',
            'password' => Hash::make('user0123'),
        ]);

        User::factory()
        ->count(5)
        ->has(
            UserAttendance::factory()
                ->count(40)
                ->has(BreakTime::factory()->count(1), 'breakTime'))
        ->create();
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'Dimitar Zlatev',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Martin Zlatev',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Hristo Zlatev',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Stanislava Zlateva',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mariana Zlateva',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ],
        ]);

        DB::table('facebook_friends')->truncate();

        DB::table('facebook_friends')->insert([
            [
                'user_id' => 1,
                'friend_id' => 3,
                'friend_name' => 'Mariana',
            ],
            [
                'user_id' => 1,
                'friend_id' => 2,
                'friend_name' => 'Sunny',
            ],
            [
                'user_id' => 1,
                'friend_id' => 1,
                'friend_name' => 'Vasko',
            ],
            [
                'user_id' => 2,
                'friend_id' => 4,
                'friend_name' => 'Vanya',
            ],
            [
                'user_id' => 2,
                'friend_id' => 5,
                'friend_name' => 'Rado',
            ],
            [
                'user_id' => 3,
                'friend_id' => 6,
                'friend_name' => 'Maria',
            ],
            [
                'user_id' => 5,
                'friend_id' => 3,
                'friend_name' => 'Mariana',
            ],
            [
                'user_id' => 4,
                'friend_id' => 6,
                'friend_name' => 'Maria',
            ],
            [
                'user_id' => 3,
                'friend_id' => 5,
                'friend_name' => 'Rado',
            ],
            [
                'user_id' => 5,
                'friend_id' => 8,
                'friend_name' => 'Elena',
            ],
            [
                'user_id' => 4,
                'friend_id' => 8,
                'friend_name' => 'Elena',
            ],
        ]);
    }
}

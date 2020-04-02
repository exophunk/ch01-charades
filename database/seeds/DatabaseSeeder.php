<?php

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
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Robert',
            'email' => 'hello@robertkrieg.ch',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Lorena',
            'email' => 'hello@lorenastrohner.ch',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('rooms')->insert([
            'id' => 1,
            'name' => 'Charades Fun Night',
        ]);

        DB::table('teams')->insert([
            'id' => 1,
            'name' => 'Team Yolo',
            'room_id' => 1,
        ]);

        DB::table('teams')->insert([
            'id' => 2,
            'name' => 'Team Badass',
            'room_id' => 1,
        ]);

        DB::table('team_users')->insert([
            'id' => 1,
            'team_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('team_users')->insert([
            'id' => 2,
            'team_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('words')->insert(['id' => 1, 'room_id' => 1, 'user_id' => 1, 'word' => 'Hasenstall']);
        DB::table('words')->insert(['id' => 2, 'room_id' => 1, 'user_id' => 1, 'word' => 'Geburtenkontrolle']);
        DB::table('words')->insert(['id' => 3, 'room_id' => 1, 'user_id' => 1, 'word' => 'Autounfall']);
        DB::table('words')->insert(['id' => 4, 'room_id' => 1, 'user_id' => 2, 'word' => 'Pandemie']);
        DB::table('words')->insert(['id' => 5, 'room_id' => 1, 'user_id' => 2, 'word' => 'Christoph Blocher']);
        DB::table('words')->insert(['id' => 6, 'room_id' => 1, 'user_id' => 2, 'word' => 'Sexgrüsel']);
    }
}

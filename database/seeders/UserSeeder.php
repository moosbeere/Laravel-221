<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'moderator',
            'email'=>'moderator@mail.ru',
            'password'=>Hash::make(123456),
            'role'=>'moderator'
        ]);
        User::create([
            'name'=>'reader',
            'email'=>'reader@mail.ru',
            'password'=>Hash::make(123456),
            'role'=>'reader'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User([
            'email' => '321@gmail.com',
            'password' => '321',
            'name' => 'Pyrky Dashboard Admin'
        ]);
        $user->save();
    }
}

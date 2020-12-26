<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = 'sebas';
        $user->email = 'sebasmirandadc@gmail.com';
        $user->document = bcrypt('1073165535');
        $user->save();

    }
}

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
        $user->apellido = 'miranda hernandez';
        $user->email = 'sebasmirandadc@gmail.com';
        $user->document = '1073165535';
        $user->mobile = '3144452921';
        $user->save();

    }
}

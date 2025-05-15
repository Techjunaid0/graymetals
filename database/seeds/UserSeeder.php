<?php

use Illuminate\Database\Seeder;
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
        $user = new User;
        $user->name 	= "GrayMetals";
        $user->email 	= "user@gmail.com"; 
        $user->password	= bcrypt(1234);
        $user->save();
    }
}

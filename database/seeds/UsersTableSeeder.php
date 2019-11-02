<?php

use App\User;
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
        $user = new User;
        $user->name = "Admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt('php');
        $user->is_admin = true;
        $user->save();

        $user = new User;
        $user->name = "Lesha";
        $user->email = "Lesha@customer.com";
        $user->password = bcrypt('lsc');
        $user->is_admin = false;
        $user->save();
    }

}

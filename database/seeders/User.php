<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $name = "Partner-One";
        $email = "partner@gmail.com";
        $password = "123456789";
        $user = new ModelsUser();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();
    }
}

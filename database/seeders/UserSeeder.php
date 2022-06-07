<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\TypeImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->user_name = "admin";
        $user->password = Hash::make("admin");
        $user->phone_number = "0597646302";
        $user->name = "محمد عليوة";
        $user->role_id = 1;
        $user->save();
    }
}

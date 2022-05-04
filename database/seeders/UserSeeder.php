<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(10)->create();
        $user = new User();
        $user->user_name = "admin";
        $user->password = Hash::make("admin");
        $user->phone_number = "0597646302";
        $user->name = "mohammed eliawa";
        $user->role_id = 1;
        $user->save();
        $types = ['صورة شخصية','شهادة ميلاد','شهادة وفاة','شهادة مدرسة','رسالة شكر'];
        foreach ($types as $type){
            $typeImage = new TypeImage();
            $typeImage->type = $type;
            $typeImage->user_id = $user->id;
            $typeImage->save();
        }

    }
}

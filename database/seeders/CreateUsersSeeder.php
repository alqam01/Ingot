<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
   
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminData =[
               'name'=>'Admin',
               'email'=>'admin@ingot.com',
               'is_admin'=>'1',
               'password'=> Hash::make(('adminadmin')),
               'referral_token'=>'refferalAdminToken123'
            ];
  
        User::create($adminData);
    }
}
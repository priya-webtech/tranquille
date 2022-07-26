<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(Role::count() == 0)
        {
            $data = [
                ['name'=> 'Admin' , 'guard_name' => 'web' ,'created_at' => date('Y-m-d h:m:s')],
            ];
            Role::insert($data);
        }
        if(User::count() == 0)
        {
            $user = User::create(['name' => 'Admin', 'email'=> 'admin@pixbrand.org', 'password' => Hash::make('12345678'), 'created_at' => date('Y-m-d h:m:s'), 'active' => 'Y', 'firstname' =>'adminuser', 'lastname' =>'User', 'profile' => 'admin/images/profile.png', 'phone' => '9876543210', 'dob' => '2000-01-01', 'type' => 'Admin','email_verified' => true, 'phone_verified' => true]);
            $user->assignRole('Admin');
        }
    }
}

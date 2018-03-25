<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_admin = Role::where('name', 'admin')->first();
    	$role_user  = Role::where('name', 'user')->first();

    	$model = new User();
    	$model->name = 'Admin';
    	$model->email = 'admin@admin.com';
    	$model->password = bcrypt('secret');
        $model->save();
        $model->roles()->attach($role_admin);
        
    	$model = new User();
    	$model->name = 'User Name';
    	$model->email = 'user@user.com';
    	$model->password = bcrypt('secret');
        $model->save();
    	$model->roles()->attach($role_user);
        
    }
}

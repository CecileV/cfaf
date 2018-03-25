<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$model = new Role();
		$model->name = 'admin';
		$model->description = 'Administrateurs';
		$model->save();

		$model = new Role();
		$model->name = 'user';
		$model->description = 'Utilisateurs';
		$model->save();
    }
}

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
		$model->created_by = '1';
		$model->save();

		$model = new Role();
		$model->name = 'user';
		$model->description = 'Utilisateurs';
		$model->created_by = '1';
		$model->save();
    }
}

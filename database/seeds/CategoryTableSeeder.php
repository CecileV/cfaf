<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 10; $i++) { 
	        $model = new Category();
	        $model->slug = 'category'.$i;
            $model->name = 'Category '.$i;
            $model->created_by = '1';
	        $model->description = 'Ceci est la description du Category '.$i.'.';
	        $model->save();
    	}
    }
}

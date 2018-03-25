<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 10; $i++) { 
	        $model = new Tag();
	        $model->slug = 'tag'.$i;
            $model->name = 'Tag '.$i;
            $model->created_by = '1';
	        $model->description = 'Ceci est la description du Tag '.$i.'.';
	        $model->save();
    	}
    }
}

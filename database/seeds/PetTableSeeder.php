<?php

use Illuminate\Database\Seeder;
use App\Pet;

class PetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Pet();
        $model->name = 'xena';
        $model->birth_day = date('Y-m-d');
        $model->identification = '';
        $model->sex = 'femelle';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. ';
        $model->health = '';
        $model->save();

        $model = new Pet();
        $model->name = 'panchos';
        $model->birth_day = date('2010-12-25');
        $model->identification = '';
        $model->sex = 'mâle';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. ';
        $model->health = '';
        $model->save();

        $model = new Pet();
        $model->name = 'fufu';
        $model->birth_day = date('2012-12-12');
        $model->identification = '';
        $model->sex = 'mâle';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. ';
        $model->health = '';
        $model->save();

    }
}

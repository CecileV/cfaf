<?php

use Illuminate\Database\Seeder;
use App\Specie;

class SpecieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Specie();
        $model->name = 'chien';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->identification = '2';
        $model->save();

        $model = new Specie();
        $model->name = 'chat';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->identification = '2';
        $model->save();

        $model = new Specie();
        $model->name = 'furet';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->identification = '2';
        $model->save();

        $model = new Specie();
        $model->name = 'hamster';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->identification = '0';
        $model->save();

    }
}

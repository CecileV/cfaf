<?php

use Illuminate\Database\Seeder;
use App\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new State();
        $model->name = 'Adopté';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->save();

        $model = new State();
        $model->name = 'A l\'adoption';
        $model->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus dolorem eaque maxime placeat quod ut veritatis. Dolorem fuga incidunt labore libero magnam officia, omnis provident sequi tempora ullam veritatis?';
        $model->save();

    }
}

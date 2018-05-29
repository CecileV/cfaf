<?php
/**
 * Created by PhpStorm.
 * User: Pikachu
 * Date: 23/05/2018
 * Time: 09:51
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->increments('pet_id');
            $table->integer('state_id')->nullable();
            $table->integer('specie_id')->nullable();
            $table->string('name');
            $table->date('birth_day')->unique();
            $table->string('identification')->nullable();
            $table->string('sex' , 10);
            $table->text('description');
            $table->string('health');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('deleted_by');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
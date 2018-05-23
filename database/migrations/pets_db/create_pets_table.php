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
            $table->increments('id');
            $table->integer('state_id');
            $table->integer('specie_id');
            $table->string('name');
            $table->date('birth_day')->unique();
            $table->string('identification')->nullable();
            $table->string('sex');
            $table->string('description');
            $table->string('health');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
            $table->index('deleted_by');
            $table->index('updated_by');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
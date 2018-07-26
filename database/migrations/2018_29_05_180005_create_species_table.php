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

class CreateSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('species', function (Blueprint $table) {
            $table->increments  ('id');
            $table->string      ('name');
            $table->boolean     ('identification')->nullable();
            $table->text        ('description');
            $table->integer     ('updated_by')->nullable();
            $table->integer     ('created_by')->nullable();
            $table->integer     ('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index       ('updated_by');
            $table->index       ('created_by');
            $table->index       ('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('species');
    }
}
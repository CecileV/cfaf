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

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments  ('tag_id');
            $table->string      ('name');
            $table->text        ('description');
            $table->integer     ('updated_by')->nullable();
            $table->index       ('updated_by');
            $table->dateTime    ('updated_at');
            $table->integer     ('created_by')->nullable();
            $table->index       ('created_by');
            $table->dateTime    ('created_at');
            $table->integer     ('deleted_by')->nullable();
            $table->index       ('deleted_by');
            $table->dateTime    ('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
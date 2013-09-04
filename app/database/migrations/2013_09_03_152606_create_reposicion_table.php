<?php

use Illuminate\Database\Migrations\Migration;

class CreateReposicionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reposicion', function($table)
        {
            $table->increments('id');
            $table->integer('permiso_id')->unsigned();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->timestamps();

            $table->foreign('permiso_id')->references('id')->on('permiso');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reposicion');
    }

}
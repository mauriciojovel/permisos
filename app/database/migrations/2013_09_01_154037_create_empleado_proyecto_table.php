<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoProyectoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleado_proyecto', function($table)
        {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();

            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('puesto');
            $table->foreign('usuario_id')->references('id')->on('usuario');
        });
    }

 	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empleado_proyecto');
  	}

}
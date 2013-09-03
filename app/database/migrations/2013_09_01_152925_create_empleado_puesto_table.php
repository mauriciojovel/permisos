<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoPuestoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleado_puesto', function($table)
        {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->integer('puesto_id')->unsigned();

            $table->timestamps();

            $table->foreign('puesto_id')->references('id')->on('puesto');
            $table->foreign('usuario_id')->references('id')->on('usuario');

            $table->unique(array('usuario_id','puesto_id'));
        });
    }

 	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empleado_puesto');
  	}

}
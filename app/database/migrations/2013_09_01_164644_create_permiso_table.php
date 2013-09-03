<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermisoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('permiso', function($table)
        {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->integer('tipo_permiso_id')->unsigned();
            $table->string('detalle',500);
            $table->date('fecha');

            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyecto');
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('tipo_permiso_id')->references('id')->on('tipo_permiso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permiso');
    }

}
<?php

use Illuminate\Database\Migrations\Migration;

class CreateTipoPermisoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('tipo_permiso', function($table)
        {
            $table->increments('id');
            $table->string('nombre',80)->unique();
            $table->boolean('uso_administrativo');
            $table->boolean('active');

            $table->timestamps();
        });
    }

 	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_permiso');
  	}
}
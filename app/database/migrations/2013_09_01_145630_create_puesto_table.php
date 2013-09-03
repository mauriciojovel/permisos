<?php

use Illuminate\Database\Migrations\Migration;

class CreatePuestoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puesto', function($table)
        {
            $table->increments('id');
            $table->integer('puesto_id')->unsigned()->nullable();
            $table->string('nombre',80)->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('active');

            $table->timestamps();

            $table->foreign('puesto_id')->references('id')->on('puesto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puesto');
    }
}
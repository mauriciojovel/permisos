<?php

use Illuminate\Database\Migrations\Migration;

class CreateProyectoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto', function($table)
        {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();
            $table->string('nombre',80)->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->boolean('active');

            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proyecto');
    }

}
<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function($table)
        {
            $table->increments('id');
            $table->string('nombre',80)->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
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
        Schema::drop('empresa');
    }

}
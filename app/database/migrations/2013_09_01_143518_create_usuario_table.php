<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function($table)
        {
            $table->increments('id');
            $table->string('name',80)->unique();
            $table->boolean('active');
            $table->boolean('admin');

            $table->timestamps();
        });
        DB::table('usuario')->insert(array(
            'name'  => 'mauricio.jovel',
            'active' => true,
            'admin' => true
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario');
    }

}
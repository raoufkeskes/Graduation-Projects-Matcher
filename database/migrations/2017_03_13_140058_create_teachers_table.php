<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('Nom',50) ;
            $table->string('Prenom',50) ;
            $table->string('Grade',10) ;
            $table->string('Profession',20)->nullable ;
            

            $table->integer('commission_de_validation_id')->unsigned()->nullable();
            $table->foreign('commission_de_validation_id')->references('id')->on('commission_de_validation')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Teacher');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nom',50) ;
            $table->string('Prenom',50) ;
            $table->string('Grade',30) ;
            $table->string('Profession',30)->nullable ;
            $table->string('Service',80)->nullable ;
            $table->integer('company_id')->unsigned()->nullable();

            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
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
        Schema::dropIfExists('representant');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                   Schema::create('cursus', function(Blueprint $table)
              {
                  $table->string('annee_universitaire_id',5);
                  $table->foreign('annee_universitaire_id')->references('annee')
                        ->on('annee_universitaire')->onDelete('cascade');

                  $table->integer('student_id')->unsigned();
                  $table->foreign('student_id')->references('id')
                        ->on('student')->onDelete('cascade');

                  $table->primary(['student_id','annee_universitaire_id']) ;

                  $table->float('moyenne');

    
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursus'); 
    }
}

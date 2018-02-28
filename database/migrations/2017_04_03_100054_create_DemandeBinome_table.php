<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeBinomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('Postule', function(Blueprint $table)
              {
                  $table->integer('student1_id')->unsigned();
                  $table->foreign('student1_id')->references('id')->on('Student')->onDelete('cascade');

                  $table->integer('student2_id')->unsigned();
                  $table->foreign('student2_id')->references('id')->on('Student')->onDelete('cascade');
                  

                  $table->primary(['student1_id','student2_id']) ;
                  
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('Postule'); 
    }
}

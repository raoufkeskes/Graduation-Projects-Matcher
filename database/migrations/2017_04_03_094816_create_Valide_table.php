<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valide', function(Blueprint $table)
              {
                  $table->integer('post_id')->unsigned();
                  $table->foreign('post_id')->references('id')
                        ->on('post')->onDelete('cascade');

                  $table->integer('teacher_id')->unsigned();
                  $table->foreign('teacher_id')->references('id')
                        ->on('teacher')->onDelete('cascade');


                  $table->primary(['post_id','teacher_id']) ;
                  $table->text('Reserve',1500)->nullable();
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
        Schema::dropIfExists('valide'); 
    }
}

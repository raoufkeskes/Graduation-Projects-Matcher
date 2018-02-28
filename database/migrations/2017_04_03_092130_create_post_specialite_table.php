<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostSpecialiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_specialite', function(Blueprint $table)
              {
                  $table->integer('post_id')->unsigned();
                  $table->foreign('post_id')->references('id')
                        ->on('post')->onDelete('cascade');

                  $table->string('specialite_id',10);
                  $table->foreign('specialite_id')->references('spec')
                        ->on('Specialite')->onDelete('cascade');

                  $table->primary(['post_id','specialite_id']) ;

                 
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_specialite'); 
    }
}

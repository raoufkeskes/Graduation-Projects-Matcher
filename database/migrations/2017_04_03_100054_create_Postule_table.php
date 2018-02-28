<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostuleTable extends Migration
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
                  $table->integer('student_id')->unsigned();
                  $table->foreign('student_id')->references('id')->on('Student')->onDelete('cascade');

                  $table->integer('post_id')->unsigned();
                  $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
                  $table->Boolean('is_Blocked')->default(0) ;

                  $table->primary(['student_id','post_id']) ;
                  $table->dateTime('created_at');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyword_post', function(Blueprint $table)
              {
                  $table->string('keyword_id',50);

                  $table->foreign('keyword_id')->references('keyword')
                        ->on('Keyword')->onDelete('cascade');

                  $table->integer('post_id')->unsigned();
                  $table->foreign('post_id')->references('id')
                        ->on('post')->onDelete('cascade');

                  $table->primary(['keyword_id','post_id']) ;
    
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword_post'); 
    }
}

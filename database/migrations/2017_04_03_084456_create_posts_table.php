<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('Domaine');
            $table->string('Titre');
            $table->text('Resume');
            $table->text('Workplan');
            $table->text('Bibliographie')->nullable();
            $table->string('Etat');
            $table->string('Type')->nullable();
            $table->string('Oriente')->default('Recherche & Pratique');
            $table->integer('NbrAvisFav')->default(0);
            $table->integer('poster_id')->unsigned()->nullable();


            $table->foreign('poster_id')->references('id')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('post');
    }
}

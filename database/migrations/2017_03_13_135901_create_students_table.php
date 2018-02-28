<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Student', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('Matricule',12)->unique() ;
            $table->string('Nom',50) ;
            $table->string('Prenom',50) ;
            $table->string('specialite',10)->nullable()  ;  

            $table->integer('Binome_id')->unsigned()->nullable();
            $table->integer('AcceptedPost_id')->unsigned()->nullable();
            $table->integer('Promoteur_interne_id')->unsigned()->nullable();
            $table->integer('Promoteur_externe_id')->unsigned()->nullable();

            $table->foreign('Binome_id')->references('id')->on('Student')->onDelete('set null');
            $table->foreign('specialite')->references('spec')->on('Specialite')->onDelete('set null');
            $table->foreign('Promoteur_interne_id')->references('id')->on('Teacher')->onDelete('set null');
            $table->foreign('Promoteur_externe_id')->references('id')->on('Representant')->onDelete('set null');

            $table->foreign('AcceptedPost_id')->references('id')->on('Post')->onDelete('set null');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Student');
    }
}

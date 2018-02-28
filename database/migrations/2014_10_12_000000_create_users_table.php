<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',30)->unique();
            $table->string('email',50)->unique();
            $table->string('password',100);
            $table->string('Telephone',10);
            $table->Boolean('is_Activated')->default(0) ;
            $table->Boolean('is_Approved')->default(0) ;
            $table->Boolean('is_Completed')->default(0) ;

            $table->integer('userable_id')->nullable();
            $table->string('userable_type',10)->nullable();

            $table->string('token', 100 )->nullable() ;


            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}

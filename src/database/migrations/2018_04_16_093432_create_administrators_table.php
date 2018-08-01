<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username', 100)->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('status')->comment('0 => Inactive, 1 => Active, 2 => Delete')->default(1);
            $table->dateTime('last_login')->nullable();
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
        Schema::dropIfExists('administrators');
    }

}

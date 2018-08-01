<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->comment('0 => Inactive, 1 => Active, 2 => Delete')->default(config('admin.database.DATABASE_DEFAULT_STATUS'));
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
        Schema::dropIfExists('roles');
    }

}

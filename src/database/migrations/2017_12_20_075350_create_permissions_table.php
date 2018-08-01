<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->comment('Root Permission')->unsigned();
            $table->string('title');
            $table->string('permission_key');
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
        Schema::dropIfExists('permissions');
    }

}

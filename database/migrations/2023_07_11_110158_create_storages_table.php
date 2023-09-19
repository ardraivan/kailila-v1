<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storage_type_id');
            $table->unsignedBigInteger('colour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('storage_type_id')->references('id')->on('storage_types')->onDelete('cascade');
            $table->foreign('colour_id')->references('id')->on('colours')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}

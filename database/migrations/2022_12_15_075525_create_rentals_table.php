<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->bigInteger('id_stuff');
            $table->bigInteger('id_item');
            $table->bigInteger('id_user');
            $table->dateTime('rental_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->dateTime('returned_date')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(2);
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
        Schema::dropIfExists('rentals');
    }
};

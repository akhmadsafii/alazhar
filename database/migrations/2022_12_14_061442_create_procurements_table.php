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
        Schema::create('procurements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->bigInteger('id_user');
            $table->integer('id_stuff');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('amount');
            $table->integer('id_source')->nullable();
            $table->bigInteger('unit_price')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->date('date_of_filing')->nullable();
            $table->date('date_received')->nullable();
            $table->enum('priority', ['urgent', 'normal']);
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
        Schema::dropIfExists('procurements');
    }
};

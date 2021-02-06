<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpbdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spbds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('spbd_no');
            $table->bigInteger('id_vendor');
            $table->dateTime('spbd_date');
            $table->integer('spbd_status');
            $table->string('spbd_user_name');
            $table->bigInteger('spbd_user_id');
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
        Schema::dropIfExists('spbds');
    }
}

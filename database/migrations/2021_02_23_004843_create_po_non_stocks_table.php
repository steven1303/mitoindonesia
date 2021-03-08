<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoNonStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_non_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('po_no');
            $table->bigInteger('id_spb')->default(0);
            $table->bigInteger('id_vendor');
            $table->integer('po_status')->default(1);
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->dateTime('po_open')->nullable();
            $table->dateTime('po_print')->nullable();
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
        Schema::dropIfExists('po_non_stocks');
    }
}

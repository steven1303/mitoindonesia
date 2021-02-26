<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpbdDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spbd_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('spbd_id')->unsigned();
            $table->bigInteger('id_stock_master');
            $table->decimal('po_qty', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('spbd_detail_status');
            $table->timestamps();

            $table->foreign('spbd_id')->references('id')->on('spbds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spbd_details');
    }
}

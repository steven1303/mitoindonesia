<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_stock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_po')->unsigned();
            $table->bigInteger('id_spbd_detail')->default(0);
            $table->bigInteger('id_stock_master');
            $table->decimal('rec_qty', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('disc', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('po_detail_status');
            $table->timestamps();

            $table->foreign('id_po')->references('id')->on('po_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_stock_details');
    }
}

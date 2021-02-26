<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rec_stock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_rec')->unsigned();
            $table->bigInteger('id_po_detail')->default(0);
            $table->bigInteger('id_mov_id')->default(0);
            $table->bigInteger('id_stock_master');
            $table->decimal('order', 10, 2)->default(0);
            $table->decimal('terima', 10, 2)->default(0);
            $table->decimal('bo', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('disc', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('rec_detail_status');
            $table->timestamps();

            $table->foreign('id_rec')->references('id')->on('rec_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rec_stock_details');
    }
}

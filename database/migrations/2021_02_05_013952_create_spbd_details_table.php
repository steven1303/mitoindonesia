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
            $table->bigInteger('spbd_id');
            $table->bigInteger('id_stock_master');
            $table->bigInteger('id_vendor');
            $table->decimal('qty', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->bigInteger('id_po_stock')->default(0);
            $table->bigInteger('po_stock_ket')->nullable();
            $table->decimal('po_stock_price', 15, 2)->default(0);
            $table->decimal('po_stock_disc', 15, 2)->default(0);
            $table->decimal('po_stock_total_harga', 15, 2)->default(0);
            $table->integer('spbd_detail_status')->default(1);
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
        Schema::dropIfExists('spbd_details');
    }
}

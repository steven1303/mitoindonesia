<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoNonStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_non_stock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_po');
            $table->bigInteger('id_spb_detail')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('disc', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('po_detail_status');
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
        Schema::dropIfExists('po_non_stock_details');
    }
}

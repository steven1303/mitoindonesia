<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_sppb_detail')->default(0);
            $table->bigInteger('id_inv');
            $table->bigInteger('id_stock_master');
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('disc', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_befppn', 10, 2)->default(0);
            $table->decimal('total_ppn', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('inv_detail_status');
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
        Schema::dropIfExists('invoice_details');
    }
}

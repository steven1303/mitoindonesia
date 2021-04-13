<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_transfer')->unsigned();
            $table->bigInteger('id_stock_master');
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('rec_qty', 10, 2)->default(0);
            $table->decimal('price',20, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('transfer_detail_status');
            $table->timestamps();

            $table->foreign('id_transfer')->references('id')->on('transfer_branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_details');
    }
}

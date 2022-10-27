<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppbNewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppb_new_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('sppb_id')->unsigned();
            $table->bigInteger('po_internal_detail_id')->unsigned();
            $table->bigInteger('id_stock_master');
            $table->decimal('inv_qty', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            
            $table->foreign('sppb_id')->references('id')->on('sppb_news')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppb_new_details');
    }
}

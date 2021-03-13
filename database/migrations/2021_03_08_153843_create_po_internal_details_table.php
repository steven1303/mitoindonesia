<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoInternalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_internal_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_po')->unsigned();
            $table->bigInteger('id_stock_master');
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('disc', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('po_detail_status');
            $table->timestamps();

            $table->foreign('id_po')->references('id')->on('po_internals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_internal_details');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppbDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppb_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('sppb_id')->unsigned();
            $table->bigInteger('id_stock_master');
            $table->decimal('inv_qty', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('sppb_detail_status')->nullable();
            $table->timestamps();

            $table->foreign('sppb_id')->references('id')->on('sppbs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppb_details');
    }
}

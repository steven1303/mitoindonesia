<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpbDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spb_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->bigInteger('spb_id')->unsigned();
            $table->string('product');
            $table->string('keterangan');
            $table->decimal('qty', 10, 2)->default(0);
            $table->string('satuan');
            $table->string('spb_detail_status');
            $table->timestamps();

            $table->foreign('spb_id')->references('id')->on('spbs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spb_details');
    }
}

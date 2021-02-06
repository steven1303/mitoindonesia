<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('po_no');
            $table->bigInteger('id_spbd');
            $table->bigInteger('id_vendor');
            $table->dateTime('po_ord_date');
            $table->integer('po_status')->default(1);
            $table->decimal('ppn', 10, 2)->default(0);
            $table->string('spbd_user_name');
            $table->bigInteger('spbd_user_id');
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
        Schema::dropIfExists('po_stocks');
    }
}

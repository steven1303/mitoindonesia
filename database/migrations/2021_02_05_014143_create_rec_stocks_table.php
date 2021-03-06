<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rec_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('rec_no')->unique();
            $table->bigInteger('id_vendor');
            $table->bigInteger('id_po_stock')->default(0);
            $table->string('rec_inv_ven');
            $table->dateTime('rec_date');
            $table->decimal('ppn', 10, 2)->default(0);
            $table->integer('status')->default(1);
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->dateTime('rec_open')->nullable();
            $table->dateTime('rec_print')->nullable();
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
        Schema::dropIfExists('rec_stocks');
    }
}

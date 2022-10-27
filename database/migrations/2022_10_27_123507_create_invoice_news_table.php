<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('inv_no')->unique();
            $table->dateTime('date');
            $table->bigInteger('id_customer');
            $table->string('inv_kirimke');
            $table->string('inv_alamatkirim');
            $table->string('mata_uang');
            $table->dateTime('top_date');
            $table->bigInteger('id_po_internal')->default(0);
            $table->string('po_cust');
            $table->decimal('ppn', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->integer('inv_status')->default(1);
            $table->dateTime('inv_open')->nullable();
            $table->dateTime('inv_print')->nullable();
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
        Schema::dropIfExists('invoice_news');
    }
}

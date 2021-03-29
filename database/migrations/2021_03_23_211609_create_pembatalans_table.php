<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembatalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembatalans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('pembatalan_no');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('pembatalan_type');
            $table->string('doc_no');
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->dateTime('po_open')->nullable();
            $table->dateTime('po_print')->nullable();
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
        Schema::dropIfExists('pembatalans');
    }
}

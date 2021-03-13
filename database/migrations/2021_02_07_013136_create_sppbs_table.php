<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppbs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('sppb_no')->unique();
            $table->string('sppb_date');
            $table->bigInteger('id_customer')->default(0);
            $table->string('sppb_po_cust');
            $table->integer('sppb_status');
            $table->integer('po_cust_status')->default(0);
            $table->string('sppb_user_name');
            $table->bigInteger('sppb_user_id');
            $table->dateTime('sppb_open')->nullable();
            $table->dateTime('sppb_print')->nullable();
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
        Schema::dropIfExists('sppbs');
    }
}

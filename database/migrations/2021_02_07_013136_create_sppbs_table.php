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
            $table->string('sppb_no');
            $table->string('sppb_date');
            $table->bigInteger('id_customer');
            $table->string('sppb_po_cust');
            $table->integer('sppb_status');
            $table->string('sppb_user_name');
            $table->bigInteger('sppb_user_id');
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

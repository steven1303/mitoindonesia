<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppbNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppb_news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('sppb_no')->unique();
            $table->string('id_po_internal')->unique(0);
            $table->string('sppb_date');
            $table->integer('sppb_status');
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
        Schema::dropIfExists('sppb_news');
    }
}

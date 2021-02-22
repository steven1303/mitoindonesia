<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spbs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('spb_no');
            $table->bigInteger('id_vendor')->default(0);
            $table->dateTime('spb_date');
            $table->integer('spb_status');
            $table->string('spb_user_name');
            $table->bigInteger('spb_user_id');
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
        Schema::dropIfExists('spbs');
    }
}

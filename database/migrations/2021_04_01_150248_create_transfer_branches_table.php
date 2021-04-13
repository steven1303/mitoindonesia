<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('transfer_no')->unique();
            $table->bigInteger('to_branch');
            $table->dateTime('transfer_date');
            $table->integer('transfer_status');
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->dateTime('transfer_open')->nullable();
            $table->dateTime('transfer_print')->nullable();
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
        Schema::dropIfExists('transfer_branches');
    }
}

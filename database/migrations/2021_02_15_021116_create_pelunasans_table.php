<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelunasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelunasans', function (Blueprint $table) {
            $table->id();
            $table->string('pelunasan_no')->unique();
            $table->bigInteger('id_branch');
            $table->bigInteger('id_inv');
            $table->decimal('balance', 10, 2)->default(0);
            $table->bigInteger('payment_method');
            $table->string('notes')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->Integer('status');
            $table->dateTime('pelunasan_open')->nullable();
            $table->dateTime('pelunasan_print')->nullable();
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
        Schema::dropIfExists('pelunasans');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('phone');
            $table->string('pic')->nullable();
            $table->string('telp')->nullable();
            $table->string('npwp');
            $table->decimal('ppn', 10, 2)->default(0);
            $table->Integer('status_ppn')->default(0);
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
        Schema::dropIfExists('vendors');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('name');
            $table->string('address1');
            $table->string('address2');
            $table->string('email')->nullable();
            $table->string('city');
            $table->string('pic')->nullable();
            $table->string('telp')->nullable();
            $table->string('phone');
            $table->string('npwp');
            $table->decimal('ppn', 10, 2)->default(0); // No used
            $table->Integer('status_ppn')->default(0);
            $table->string('ktp');
            $table->string('bod');
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
        Schema::dropIfExists('customers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_internals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('po_no')->unique();
            $table->bigInteger('id_customer');
            $table->string('doc_no')->nullable();
            $table->integer('po_status')->default(1);
            $table->decimal('ppn', 10, 2)->default(0);
            $table->string('po_user_name');
            $table->bigInteger('po_user_id');
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
        Schema::dropIfExists('po_internals');
    }
}

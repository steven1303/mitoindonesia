<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceToSppbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sppbs', function (Blueprint $table) {
            $table->string('invoice_id')->after('id_customer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sppbs', function (Blueprint $table) {
            $table->string('invoice_id')->after('id_customer')->default(0);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('inv_no')->unique();
            $table->dateTime('date');
            $table->bigInteger('id_customer');
            $table->string('inv_kirimke');
            $table->string('inv_alamatkirim');
            $table->string('mata_uang');
            $table->dateTime('top_date');
            $table->bigInteger('id_po_internal')->default(0);
            $table->string('po_cust');
            $table->decimal('ppn', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('user_name');
            $table->bigInteger('user_id');
            $table->integer('inv_status')->default(1);
            $table->dateTime('inv_open')->nullable();
            $table->dateTime('inv_print')->nullable();
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-view',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-store',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-update',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-delete',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-open',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-approve',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-print',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-verify1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-verify2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'InvoiceNew',
                'name' => 'invoice-new-reject',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_news');
    }
}

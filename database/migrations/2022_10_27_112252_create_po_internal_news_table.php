<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoInternalNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_internal_news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_branch');
            $table->string('po_no')->unique();
            $table->bigInteger('id_customer');
            $table->string('doc_no')->nullable();
            $table->integer('po_status')->default(1);
            $table->decimal('ppn', 20, 2)->default(0);
            $table->string('po_user_name');
            $table->bigInteger('po_user_id');
            $table->dateTime('po_open')->nullable();
            $table->dateTime('po_print')->nullable();
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-view',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-store',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-update',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-delete',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-open',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-approve',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'PoInternalNew',
                'name' => 'po-internal-new-print',
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
        Schema::dropIfExists('po_internal_news');
    }
}

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

        DB::table('permissions')->insert([
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-view',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-store',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-update',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-delete',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-open',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-approve',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-print',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-verify1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-verify2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'stat' => 1,
            ],
            [
                'for' => 'SppbNew',
                'name' => 'sppb-new-pembatalan',
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
        Schema::dropIfExists('sppb_news');
    }
}

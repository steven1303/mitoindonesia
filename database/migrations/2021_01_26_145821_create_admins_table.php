<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('id_role');
            $table->bigInteger('id_branch');
            $table->Integer('status_akses')->default(0);
            $table->timestamps();
        });

        DB::table('admins')->insert([
            'name' => 'administrator',
            'username' => 'administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12341234'),
            'id_role' => 1,
            'id_branch' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}

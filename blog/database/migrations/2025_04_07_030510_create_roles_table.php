<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 15)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');
           // $table->primary(['user_id', 'role_id'])
        });

        $date = now()->format('Y-m-d H:i:s');
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'name' => 'author', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'name' => 'reader', 'created_at' => $date, 'updated_at' => $date],
        ]);

        DB::table('user_roles')->insert([
            'user_id' => 1, 'role_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles');
    }
}

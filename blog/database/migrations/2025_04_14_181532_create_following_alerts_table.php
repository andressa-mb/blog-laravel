<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowingAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('following_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alert_id')
            ->references('id')
            ->on('post_alerts')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('post_id')
            ->references('id')
            ->on('posts')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('author_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('follower_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->boolean('readed')->default(false);
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
        Schema::dropIfExists('following_alerts');
    }
}

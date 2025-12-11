<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertAuthorsFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_authors_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alertPost_id')
            ->references('id')
            ->on('alert_posts')
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
            $table->timestamp('processed_at')->nullable();
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
        Schema::dropIfExists('alert_authors_followers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
            $table->timestamps();
        });

        Schema::create('categories_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('categories_posts');
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('sub_cat_id');
            $table->integer('tag_id');
            $table->integer('brand_id');
            $table->integer('author_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('image')->nullable();
            $table->tinyInteger('feature');
            $table->tinyInteger('approve');
            $table->tinyInteger('publish');
            $table->tinyInteger('deleted_at');
            $table->date('date');
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
        Schema::dropIfExists('products');
    }
}

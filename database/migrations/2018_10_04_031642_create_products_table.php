<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id_product');
            $table->string('name', 50);
            $table->decimal('price', 16, 2);
            $table->string('image', 100)->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id_category')->on('categories');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('users');
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

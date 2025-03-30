<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->foreignId('cart_id')->constrained('carts', 'id')->onDelete('cascade');
            $table->integer('product_id')->constrained('products_specifics', 'product_id');
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL']);
            $table->enum('color', ['black', 'white', 'red', 'blue', 'green']);
            $table->integer('quantity');
            $table->timestamps();
            $table->primary(['cart_id', 'product_id', 'size', 'color']);

            $table->foreign(['product_id', 'size', 'color'])
                ->references(['product_id', 'size', 'color'])
                ->on('product_specifics')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartitems');
    }
}

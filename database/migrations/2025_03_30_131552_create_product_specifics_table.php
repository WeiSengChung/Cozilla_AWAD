<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specifics', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products',"id")->onDelete('cascade');
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL']);
            $table->enum('color', ['black', 'white', 'red', 'blue', 'green']);
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
            $table->primary(['product_id', 'size', 'color']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_specifics');
    }
}

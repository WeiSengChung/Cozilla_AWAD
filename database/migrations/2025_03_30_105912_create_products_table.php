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
            $table->foreignId('category_id')->constrained('categories', 'id')->onDelete('cascade');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL']);
            $table->enum('color', ['black', 'white', 'red', 'blue', 'green']);
            $table->integer('stock_quantity')->default(0);
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

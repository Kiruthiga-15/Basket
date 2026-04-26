<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('variation_type_size_id')->nullable();
            $table->unsignedBigInteger('variation_value_size_id')->nullable();

            $table->unsignedBigInteger('variation_type_color_id')->nullable();
            $table->unsignedBigInteger('variation_value_color_id')->nullable();

            $table->string('name');
            $table->string('slug')->unique();

            $table->decimal('price',10,2);
            $table->decimal('discount_price',10,2)->nullable();

            $table->string('sku')->unique()->nullable();

            $table->integer('stock')->default(0);

            $table->decimal('delivery_charge',10,2)->default(0);

            $table->string('discount_type')->nullable(); // percent / fixed
            $table->decimal('discount_value',10,2)->nullable();

            $table->string('main_image')->nullable();

            $table->longText('gallery')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
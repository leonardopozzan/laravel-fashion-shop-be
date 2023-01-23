<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name', 100)->unique();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->float('price', 6, 2)->unsigned();
            $table->string('image')->nullable();
            $table->float('rating', 2, 1)->nullable()->unsigned();
            $table->boolean('available');
            $table->string('detail_link')->nullable();
            $table->foreignId('type_id')->cascadeOnUpdate()->nullOnDelete()->nullable()->constrained();
            $table->foreignId('brand_id')->cascadeOnUpdate()->nullOnDelete()->nullable()->constrained();
            $table->foreignId('category_id')->cascadeOnUpdate()->nullOnDelete()->nullable()->constrained();
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
};

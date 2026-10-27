<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedInteger('units_per_pack')->default(1);   // 20 for cigarettes, 1 for the rest
            $table->unsignedInteger('stock')->default(0);            // in smallest unit (sticks / pieces)
            $table->decimal('cost_price', 10, 2)->default(0);        // what you pay per pack
            $table->decimal('price_per_pack', 10, 2);                // selling price per pack
            $table->decimal('price_per_stick', 10, 2)->nullable();   // only for cigarettes
            $table->unsignedInteger('reorder_level')->default(0);    // low-stock warning, in packs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

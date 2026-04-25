<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category', 50);
            $table->unsignedInteger('price');
            $table->unsignedInteger('old_price')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->string('sold', 20)->default('0');
            $table->string('color', 60)->nullable();
            $table->string('emoji', 8)->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

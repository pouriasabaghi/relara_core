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
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percentage']);
            $table->bigInteger('value'); // Iranian Rial 💔
            $table->bigInteger('min_cart_value')->nullable();
            $table->bigInteger('max_discount_value')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};

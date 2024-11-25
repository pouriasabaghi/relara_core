<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin', 'developer'])->default('user');
            $table->string('avatar')->nullable();
            $table->string('national_id', 10)->nullable();
            $table->string('mobile', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('avatar');
            $table->dropColumn('national_id');
            $table->dropColumn('mobile');
        });
    }
};

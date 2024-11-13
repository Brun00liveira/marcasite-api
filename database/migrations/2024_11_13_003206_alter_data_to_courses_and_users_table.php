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
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');;
            $table->boolean('is_active')->default(true)->after('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after("phone");;
            $table->boolean('is_active')->default(true)->after("id");
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'is_active']);
        });

        // Remover alterações na tabela 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'is_active']);
        });
    }
};

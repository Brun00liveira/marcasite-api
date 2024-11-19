<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('id'); // Ajuste o "after" conforme necessário
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
        });
    }
};

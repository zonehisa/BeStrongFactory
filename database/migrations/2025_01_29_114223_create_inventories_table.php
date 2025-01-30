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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('user_id')->constrained('users'); // 担当者ID（外部キー）
            $table->string('item_name')->unique(); // 商品名
            $table->integer('current_stock')->default(0); // 現在の在庫数
            $table->integer('minimum_stock')->default(0);  // 最小在庫数（安全在庫数）
            $table->integer('package_quantity')->default(1);  // 1パッケージあたりの入り数
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at（論理削除用）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

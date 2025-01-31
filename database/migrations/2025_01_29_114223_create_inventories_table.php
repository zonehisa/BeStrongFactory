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
            $table->string('item_code')->unique(); // 品番（一意）
            $table->string('item_name'); // 商品名
            $table->integer('current_stock')->default(0); // 現在の在庫数
            $table->integer('minimum_stock')->default(0);  // 最小在庫数（安全在庫数）
            $table->integer('package_quantity')->default(1);  // 1パッケージあたりの入り数
            $table->string('supplier_name')->nullable(); // 仕入先
            $table->string('customer_name')->nullable(); // 顧客
            $table->decimal('purchase_price', 10, 2)->nullable(); // 仕入れ価格
            $table->decimal('selling_price', 10, 2)->nullable(); // 販売価格
            $table->integer('lead_time')->nullable(); // 納期（日数）
            $table->string('drawing_file')->nullable(); // 図面ファイルパス
            $table->text('notes')->nullable(); // 備考
            $table->foreignId('user_id')->constrained('users'); // 担当者ID（外部キー）
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

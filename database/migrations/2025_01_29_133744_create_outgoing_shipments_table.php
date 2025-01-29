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
        Schema::create('outgoing_shipments', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade'); // 在庫ID（外部キー）
            $table->foreignId('user_id')->constrained()->comment('担当者'); // 担当者ID（外部キー）
            $table->integer('quantity'); // 出荷数量
            $table->decimal('unit_price', 10, 2)->nullable(); // まだ実装しない
            $table->string('customer_name')->nullable(); // 顧客名
            $table->string('order_number')->nullable(); // 注文番号
            $table->date('shipped_date'); // 出荷日
            $table->string('status')->default('pending'); // ステータス（pending:保留中、completed:完了、cancelled:キャンセル）
            $table->text('notes')->nullable(); // 備考
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at（論理削除用）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_shipments');
    }
};

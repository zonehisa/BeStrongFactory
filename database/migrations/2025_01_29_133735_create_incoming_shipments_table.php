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
        Schema::create('incoming_shipments', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade'); // 在庫ID（外部キー）
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID（外部キー）
            $table->integer('quantity'); // 入荷数量
            $table->decimal('unit_price', 10, 2)->nullable(); // 単価
            $table->string('unit')->nullable(); // 単位
            $table->string('supplier_name'); // 仕入先名
            $table->string('lot_number')->nullable(); // ロット番号
            $table->date('received_date'); // 入荷日
            $table->string('status')->default('completed'); // ステータス（pending:保留中、completed:完了、cancelled:キャンセル）
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
        Schema::dropIfExists('incoming_shipments');
    }
};

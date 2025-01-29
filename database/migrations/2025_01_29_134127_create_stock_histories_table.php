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
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade'); // 在庫ID（外部キー）
            $table->integer('stock_quantity'); // 在庫数量
            $table->date('record_date'); // 記録日
            $table->string('movement_type')->nullable(); // 在庫変動タイプ（initial:初期在庫、incoming:入荷、outgoing:出荷）
            $table->foreignId('reference_id')->nullable(); // 関連レコードID（入荷または出荷テーブルのID）
            $table->string('reference_type')->nullable(); // 関連レコードタイプ（IncomingShipmentまたはOutgoingShipment）
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at（論理削除用）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};

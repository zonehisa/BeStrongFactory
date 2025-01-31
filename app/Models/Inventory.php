<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'item_code',         // 品番
        'item_name',         // 商品名
        'current_stock',     // 現在の在庫数
        'minimum_stock',     // 最小在庫数（安全在庫数）
        'package_quantity',  // 1パッケージあたりの入り数
        'supplier_name',     // 仕入先
        'customer_name',     // 顧客
        'purchase_price',    // 仕入れ価格
        'selling_price',     // 販売価格
        'lead_time',         // 納期（日数）
        'drawing_file',      // 図面ファイルパス
        'notes',             // 備考
        'user_id',           // 担当者ID
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'alert_triggered' => 'boolean',  // アラート発生フラグ
        'last_order_date' => 'date',     // 最終発注日
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'lead_time' => 'integer',
    ];

    /**
     * 入荷テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomingShipments()
    {
        return $this->hasMany(IncomingShipment::class);
    }

    /**
     * 出荷テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outgoingShipments()
    {
        return $this->hasMany(OutgoingShipment::class);
    }

    /**
     * 在庫履歴テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    /**
     * 在庫数を更新し、履歴を記録する
     *
     * @param int $quantity 数量
     * @param string $type 変動タイプ（incoming:入荷、outgoing:出荷）
     * @param Model|null $referenceModel 関連モデル
     * @return void
     */
    public function updateStock($quantity, $type, $referenceModel = null)
    {
        if ($type === 'incoming') {
            $this->current_stock += $quantity;
        } elseif ($type === 'outgoing') {
            $this->current_stock -= $quantity;
        }
        $this->save();

        // 在庫履歴を記録
        $this->stockHistories()->create([
            'stock_quantity' => $this->current_stock,
            'record_date' => now()->toDateString(),
            'movement_type' => $type,
            'reference_id' => $referenceModel ? $referenceModel->id : null,
            'reference_type' => $referenceModel ? get_class($referenceModel) : null,
            'user_id' => Auth::id(), // 現在のユーザーIDを保存
        ]);
    }

    /**
     * 指定日時点の在庫数を取得する
     *
     * @param string $date 日付
     * @return int
     */
    public function getStockAtDate($date)
    {
        return $this->stockHistories()
            ->where('record_date', '<=', $date)
            ->orderBy('record_date', 'desc')
            ->orderBy('id', 'desc')
            ->first()
            ?->stock_quantity ?? $this->current_stock;
    }
}

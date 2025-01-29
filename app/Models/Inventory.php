<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',           // ユーザーID
        'item_name',         // 商品名
        'current_stock',     // 現在の在庫数
        'minimum_stock',     // 最小在庫数
        'package_quantity',  // パッケージ数量
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'alert_triggered' => 'boolean',  // アラート発生フラグ
        'last_order_date' => 'date',     // 最終発注日
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

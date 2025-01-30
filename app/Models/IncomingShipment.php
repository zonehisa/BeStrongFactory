<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomingShipment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括代入可能な属性
     * 
     * @var array
     */
    protected $fillable = [
        'inventory_id',   // 在庫ID
        'user_id',        // 担当者ID
        'quantity',       // 入荷数量
        'unit_price',     // 単価
        'unit',           // 単位
        'supplier_name',  // 仕入先名
        'lot_number',     // ロット番号
        'received_date',  // 入荷日
        'status',         // ステータス
        'notes',         // 備考
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'received_date' => 'date',      // 日付型にキャスト
        'unit_price' => 'decimal:2',    // 小数点2桁の数値型にキャスト
    ];

    /**
     * モデルの初期起動時の処理
     */
    protected static function booted()
    {
        // 入荷登録時の処理
        static::created(function ($incomingShipment) {
            // パッケージ数量を考慮した実際の入荷数を計算
            $actualQuantity = $incomingShipment->quantity * $incomingShipment->inventory->package_quantity;

            $incomingShipment->inventory->updateStock(
                $actualQuantity,
                'incoming',
                $incomingShipment
            );
        });

        // 入荷削除時の処理
        static::deleted(function ($incomingShipment) {
            if (!$incomingShipment->isForceDeleting()) {
                // パッケージ数量を考慮した実際の入荷数を計算
                $actualQuantity = $incomingShipment->quantity * $incomingShipment->inventory->package_quantity;

                $incomingShipment->inventory->updateStock(
                    -$actualQuantity,
                    'incoming',
                    $incomingShipment
                );
            }
        });

        // 入荷復元時の処理
        static::restored(function ($incomingShipment) {
            // パッケージ数量を考慮した実際の入荷数を計算
            $actualQuantity = $incomingShipment->quantity * $incomingShipment->inventory->package_quantity;

            $incomingShipment->inventory->updateStock(
                $actualQuantity,
                'incoming',
                $incomingShipment
            );
        });
    }

    /**
     * 在庫テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * 在庫履歴テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function stockHistory()
    {
        return $this->morphOne(StockHistory::class, 'reference');
    }

    /**
     * 担当者テーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

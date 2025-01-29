<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutgoingShipment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'inventory_id',   // 在庫ID
        'user_id',        // ユーザーID
        'quantity',       // 出荷数量
        'unit_price',     // 単価
        'customer_name',  // 顧客名
        'order_number',   // 注文番号
        'shipped_date',   // 出荷日
        'status',         // ステータス
        'notes',          // 備考
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'shipped_date' => 'date',      // 日付型にキャスト
        'unit_price' => 'decimal:2',   // 小数点2桁の数値型にキャスト
    ];

    /**
     * モデルの初期起動時の処理
     */
    protected static function booted()
    {
        // 出荷登録時の処理
        static::created(function ($outgoingShipment) {
            $outgoingShipment->inventory->updateStock(
                $outgoingShipment->quantity,
                'outgoing',
                $outgoingShipment
            );
        });

        // 出荷削除時の処理
        static::deleted(function ($outgoingShipment) {
            if (!$outgoingShipment->isForceDeleting()) {
                $outgoingShipment->inventory->updateStock(
                    -$outgoingShipment->quantity,
                    'outgoing',
                    $outgoingShipment
                );
            }
        });

        // 出荷復元時の処理
        static::restored(function ($outgoingShipment) {
            $outgoingShipment->inventory->updateStock(
                $outgoingShipment->quantity,
                'outgoing',
                $outgoingShipment
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
}

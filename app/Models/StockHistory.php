<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockHistory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'inventory_id',    // 在庫ID
        'stock_quantity',  // 在庫数量
        'record_date',     // 記録日
        'movement_type',   // 変動タイプ（incoming:入荷、outgoing:出荷）
        'reference_id',    // 参照ID
        'reference_type',  // 参照タイプ
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'record_date' => 'date',  // 日付型にキャスト
    ];

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
     * 多態リレーション（入荷・出荷）
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reference()
    {
        return $this->morphTo();
    }
}

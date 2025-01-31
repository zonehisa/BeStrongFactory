<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockHistory;
use App\Models\Inventory;

class StockHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockHistory::with(['inventory', 'user', 'reference']);

        // 商品でフィルター
        if ($request->filled('inventory_id')) {
            $query->where('inventory_id', $request->inventory_id);
        }

        // 変動タイプでフィルター
        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }

        // 日付範囲でフィルター
        if ($request->filled('date_from')) {
            $query->whereDate('record_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('record_date', '<=', $request->date_to);
        }

        $stockHistories = $query->latest('record_date')->paginate(20);
        $inventories = Inventory::orderBy('item_name')->get();

        return view('stock_histories.index', compact('stockHistories', 'inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock_histories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'stock_quantity' => ['required', 'integer'],
            'record_date' => ['required', 'date'],
            'movement_type' => ['required', 'string'],
            'reference_id' => ['nullable', 'integer'],
            'reference_type' => ['nullable', 'string'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stockHistory = StockHistory::findOrFail($id);
        return view('stock_histories.show', compact('stockHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stockHistory = StockHistory::findOrFail($id);
        return view('stock_histories.edit', compact('stockHistory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'inventory_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'stock_quantity' => ['required', 'integer'],
            'record_date' => ['required', 'date'],
            'movement_type' => ['required', 'string'],
            'reference_id' => ['nullable', 'integer'],
            'reference_type' => ['nullable', 'string'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stockHistory = StockHistory::findOrFail($id);
        $stockHistory->delete();
        return redirect()->route('stock_histories.index')
            ->with('success', '在庫履歴を削除しました。');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::all();

        return view('inventories.index', ['inventories' => $inventories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_code' => ['required', 'string', 'unique:inventories,item_code'],
            'item_name' => ['required', 'string'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'package_quantity' => ['required', 'integer', 'min:1'],
        ], [
            'item_code.required' => '品番を入力してください。',
            'item_code.unique' => 'この品番は既に登録されています。',
            'item_name.required' => '商品名を入力してください。',
            'minimum_stock.required' => '最小在庫数を入力してください。',
            'minimum_stock.integer' => '最小在庫数は整数で入力してください。',
            'minimum_stock.min' => '最小在庫数は0以上で入力してください。',
            'package_quantity.required' => 'パッケージ数量を入力してください。',
            'package_quantity.integer' => 'パッケージ数量は整数で入力してください。',
            'package_quantity.min' => 'パッケージ数量は1以上で入力してください。',
        ]);

        $inventory = new Inventory();
        $inventory->item_code = $request->item_code;
        $inventory->item_name = $request->item_name;
        $inventory->minimum_stock = $request->minimum_stock;
        $inventory->package_quantity = $request->package_quantity;
        $inventory->user_id = Auth::id();
        $inventory->save();

        return redirect()->route('inventories.index')
            ->with('success', '商品を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::find($id);
        return view('inventories.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = Inventory::find($id);

        $inventory->item_name = $request->item_name;
        $inventory->current_stock = $request->current_stock;
        $inventory->minimum_stock = $request->minimum_stock;
        $inventory->package_quantity = $request->package_quantity;
        $inventory->save();

        return redirect()->route('inventories.index')
            ->with('success', '更新が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

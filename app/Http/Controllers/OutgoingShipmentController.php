<?php

namespace App\Http\Controllers;

use App\Models\OutgoingShipment;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutgoingShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outgoingShipments = OutgoingShipment::with(['inventory', 'user'])->latest()->get();
        return view('outgoing_shipments.index', compact('outgoingShipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $inventories = Inventory::all();
        $selectedInventoryId = $request->query('inventory_id');
        return view('outgoing_shipments.create', compact('inventories', 'selectedInventoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => ['required', 'exists:inventories,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'inventory_id.required' => '商品を選択してください。',
            'inventory_id.exists' => '選択された商品は存在しません。',
            'quantity.required' => '出庫数量を入力してください。',
            'quantity.integer' => '出庫数量は整数で入力してください。',
            'quantity.min' => '出庫数量は1以上で入力してください。',
        ]);

        $inventory = Inventory::findOrFail($request->inventory_id);

        // 在庫不足チェック
        if ($inventory->current_stock < $request->quantity) {
            return back()->withErrors(['quantity' => '在庫が不足しています。'])->withInput();
        }

        // 出庫情報を記録
        $outgoingShipment = new OutgoingShipment();
        $outgoingShipment->inventory_id = $request->inventory_id;
        $outgoingShipment->user_id = Auth::id();
        $outgoingShipment->quantity = $request->quantity;
        $outgoingShipment->shipped_date = now();
        $outgoingShipment->status = 'completed';
        $outgoingShipment->save();

        // 在庫数を更新
        $inventory->current_stock -= $request->quantity;
        $inventory->save();

        return redirect()->route('inventories.index')
            ->with('success', "{$inventory->item_name}を{$request->quantity}個出庫しました。");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

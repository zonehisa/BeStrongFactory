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
        $inventory = new Inventory();
        $inventory->user_id = Auth::id();
        $inventory->item_name = $request->item_name;
        $inventory->minimum_stock = $request->minimum_stock;
        $inventory->package_quantity = $request->package_quantity;
        $inventory->save();

        return redirect()->route('inventories.index')
            ->with('success', '登録が完了しました。');
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

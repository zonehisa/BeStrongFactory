<?php

namespace App\Http\Controllers;

use App\Models\IncomingShipment;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomingShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomingShipments = IncomingShipment::all();
        return view('incoming_shipments.index', compact('incomingShipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $inventories = Inventory::all();
        $selectedInventoryId = $request->query('inventory_id');  // URLパラメータから商品IDを取得

        return view('incoming_shipments.create', compact('inventories', 'selectedInventoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => ['required', 'exists:inventories,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'supplier_name' => ['required', 'string', 'max:255'],
        ], [
            'inventory_id.required' => '商品を選択してください。',
            'inventory_id.exists' => '選択された商品は存在しません。',
            'quantity.required' => '入庫数量を入力してください。',
            'quantity.integer' => '入庫数量は整数で入力してください。',
            'quantity.min' => '入庫数量は1以上で入力してください。',
            'supplier_name.required' => '仕入先を入力してください。',
        ]);

        try {
            DB::beginTransaction();

            $inventory = Inventory::findOrFail($request->inventory_id);

            // 入庫情報を記録
            $incomingShipment = new IncomingShipment();
            $incomingShipment->inventory_id = $request->inventory_id;
            $incomingShipment->user_id = Auth::id();
            $incomingShipment->quantity = $request->quantity;
            $incomingShipment->supplier_name = $request->supplier_name;
            $incomingShipment->received_date = now();
            $incomingShipment->status = 'completed';
            $incomingShipment->save();

            DB::commit();
            return redirect()->route('inventories.index')
                ->with('success', "{$inventory->item_name}を{$request->quantity}個入庫しました。");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => '入庫処理に失敗しました。']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incomingShipment = IncomingShipment::findOrFail($id);
        return view('incoming_shipments.show', compact('incomingShipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $incomingShipment = IncomingShipment::findOrFail($id);
        $inventories = Inventory::all(); // 在庫の一覧を取得
        return view('incoming_shipments.edit', compact('incomingShipment', 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:10'],
            'supplier_name' => ['nullable', 'string', 'max:255'],
            'lot_number' => ['nullable', 'string', 'max:50'],
            'received_date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'string', 'in:pending,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'quantity.required' => '入荷数量を入力してください。',
            'quantity.integer' => '入荷数量は整数で入力してください。',
            'quantity.min' => '入荷数量は1以上で入力してください。',
            'unit_price.numeric' => '単価は数値で入力してください。',
            'unit_price.min' => '単価は0以上で入力してください。',
            'unit.required' => '単位を入力してください。',
            'unit.max' => '単位は10文字以内で入力してください。',
            'supplier_name.max' => '仕入先は255文字以内で入力してください。',
            'lot_number.max' => 'ロット番号は50文字以内で入力してください。',
            'received_date.required' => '入荷日を入力してください。',
            'received_date.date' => '入荷日は日付形式で入力してください。',
            'received_date.before_or_equal' => '入荷日は今日以前の日付を入力してください。',
            'status.required' => 'ステータスを選択してください。',
            'status.in' => '無効なステータスが選択されました。',
            'notes.max' => '備考は1000文字以内で入力してください。',
        ]);

        $incomingShipment = IncomingShipment::findOrFail($id);
        $incomingShipment->quantity = $request->quantity;
        $incomingShipment->unit_price = $request->unit_price;
        $incomingShipment->unit = $request->unit;
        $incomingShipment->supplier_name = $request->supplier_name;
        $incomingShipment->lot_number = $request->lot_number;
        $incomingShipment->received_date = $request->received_date;
        $incomingShipment->status = $request->status;
        $incomingShipment->notes = $request->notes;
        $incomingShipment->save();

        return redirect()->route('incoming_shipments.show', $incomingShipment)
            ->with('success', '入荷情報を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incomingShipment = IncomingShipment::findOrFail($id);
        $incomingShipment->delete();

        return redirect()->route('incoming_shipments.index')->with('success', '入荷が削除されました。');
    }
}

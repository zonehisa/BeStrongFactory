<?php

namespace App\Http\Controllers;

use App\Models\OutgoingShipment;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'customer_name' => ['required', 'string', 'max:255'],
        ], [
            'inventory_id.required' => '商品を選択してください。',
            'inventory_id.exists' => '選択された商品は存在しません。',
            'quantity.required' => '出庫数量を入力してください。',
            'quantity.integer' => '出庫数量は整数で入力してください。',
            'quantity.min' => '出庫数量は1以上で入力してください。',
            'customer_name.required' => '顧客名を入力してください。',
            'customer_name.max' => '顧客名は255文字以内で入力してください。',
        ]);

        try {
            DB::beginTransaction();

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
            $outgoingShipment->customer_name = $request->customer_name;
            $outgoingShipment->shipped_date = now();
            $outgoingShipment->status = 'completed';
            $outgoingShipment->save();

            DB::commit();
            return redirect()->route('inventories.index')
                ->with('success', "{$inventory->item_name}を{$request->quantity}個出庫しました。");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => '出庫処理に失敗しました。']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $outgoingShipment = OutgoingShipment::with(['inventory', 'user'])->findOrFail($id);
        return view('outgoing_shipments.show', compact('outgoingShipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $outgoingShipment = OutgoingShipment::findOrFail($id);
        $inventories = Inventory::all();
        return view('outgoing_shipments.edit', compact('outgoingShipment', 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'customer_name' => ['required', 'string', 'max:255'],
            'order_number' => ['nullable', 'string', 'max:50'],
            'shipped_date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'string', 'in:pending,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'quantity.required' => '出庫数量を入力してください。',
            'quantity.integer' => '出庫数量は整数で入力してください。',
            'quantity.min' => '出庫数量は1以上で入力してください。',
            'customer_name.required' => '顧客名を入力してください。',
            'customer_name.max' => '顧客名は255文字以内で入力してください。',
            'order_number.max' => '注文番号は50文字以内で入力してください。',
            'shipped_date.required' => '出荷日を入力してください。',
            'shipped_date.date' => '出荷日は日付形式で入力してください。',
            'shipped_date.before_or_equal' => '出荷日は今日以前の日付を入力してください。',
            'status.required' => 'ステータスを選択してください。',
            'status.in' => '無効なステータスが選択されました。',
            'notes.max' => '備考は1000文字以内で入力してください。',
        ]);

        $outgoingShipment = OutgoingShipment::findOrFail($id);

        // 在庫不足チェック（数量が増加する場合のみ）
        if ($request->quantity > $outgoingShipment->quantity) {
            $additionalQuantity = $request->quantity - $outgoingShipment->quantity;
            if ($outgoingShipment->inventory->current_stock < $additionalQuantity) {
                return back()->withErrors(['quantity' => '在庫が不足しています。'])->withInput();
            }
        }

        $outgoingShipment->quantity = $request->quantity;
        $outgoingShipment->customer_name = $request->customer_name;
        $outgoingShipment->order_number = $request->order_number;
        $outgoingShipment->shipped_date = $request->shipped_date;
        $outgoingShipment->status = $request->status;
        $outgoingShipment->notes = $request->notes;
        $outgoingShipment->save();

        return redirect()->route('outgoing_shipments.show', $outgoingShipment)
            ->with('success', '出庫情報を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $outgoingShipment = OutgoingShipment::findOrFail($id);
        $outgoingShipment->delete();

        return redirect()->route('outgoing_shipments.index')->with('success', '出庫が削除されました。');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::all();
        $lowStockItems = $inventories->filter(function ($inventory) {
            return $inventory->current_stock < $inventory->minimum_stock;
        });

        return view('inventories.index', compact('inventories', 'lowStockItems'));
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
            'supplier_name' => ['nullable', 'string', 'max:255'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'lead_time' => ['nullable', 'integer', 'min:0'],
            'drawing_file' => ['nullable', 'image', 'max:2048'], // 最大2MB
            'notes' => ['nullable', 'string'],
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
            'purchase_price.numeric' => '仕入れ価格は数値で入力してください。',
            'purchase_price.min' => '仕入れ価格は0以上で入力してください。',
            'selling_price.numeric' => '販売価格は数値で入力してください。',
            'selling_price.min' => '販売価格は0以上で入力してください。',
            'lead_time.integer' => '納期は整数で入力してください。',
            'lead_time.min' => '納期は0以上で入力してください。',
            'drawing_file.image' => '図面ファイルは画像ファイルを選択してください。',
            'drawing_file.max' => '図面ファイルは2MB以下にしてください。',
        ]);

        DB::beginTransaction();
        try {
            $inventory = new Inventory();
            $inventory->item_code = $request->item_code;
            $inventory->item_name = $request->item_name;
            $inventory->minimum_stock = $request->minimum_stock;
            $inventory->package_quantity = $request->package_quantity;
            $inventory->supplier_name = $request->supplier_name;
            $inventory->customer_name = $request->customer_name;
            $inventory->purchase_price = $request->purchase_price;
            $inventory->selling_price = $request->selling_price;
            $inventory->lead_time = $request->lead_time;
            $inventory->notes = $request->notes;
            $inventory->user_id = Auth::id();

            // 図面ファイルのアップロード処理
            if ($request->hasFile('drawing_file')) {
                $file = $request->file('drawing_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('drawings', $filename);
                $inventory->drawing_file = $filename;
            }

            $inventory->save();

            DB::commit();
            return redirect()->route('inventories.index')
                ->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            // アップロードしたファイルが存在する場合は削除
            if (isset($filename)) {
                Storage::delete('drawings/' . $filename);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => '商品の登録に失敗しました。']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = Inventory::find($id);
        return view('inventories.show', compact('inventory'));
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
        $request->validate([
            'item_code' => ['required', 'string', 'unique:inventories,item_code,' . $id],
            'item_name' => ['required', 'string'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'package_quantity' => ['required', 'integer', 'min:1'],
            'supplier_name' => ['nullable', 'string', 'max:255'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'lead_time' => ['nullable', 'integer', 'min:0'],
            'drawing_file' => ['nullable', 'image', 'max:2048'],
            'notes' => ['nullable', 'string'],
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

        try {
            DB::beginTransaction();

            $inventory = Inventory::findOrFail($id);
            $oldDrawingFile = $inventory->drawing_file;

            $inventory->item_code = $request->item_code;
            $inventory->item_name = $request->item_name;
            $inventory->minimum_stock = $request->minimum_stock;
            $inventory->package_quantity = $request->package_quantity;
            $inventory->supplier_name = $request->supplier_name;
            $inventory->customer_name = $request->customer_name;
            $inventory->purchase_price = $request->purchase_price;
            $inventory->selling_price = $request->selling_price;
            $inventory->lead_time = $request->lead_time;
            $inventory->notes = $request->notes;

            // 新しい図面ファイルがアップロードされた場合
            if ($request->hasFile('drawing_file')) {
                $file = $request->file('drawing_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('drawings', $filename);
                $inventory->drawing_file = $filename;

                // 古い図面ファイルを削除
                if ($oldDrawingFile) {
                    Storage::delete('drawings/' . $oldDrawingFile);
                }
            }

            $inventory->save();

            DB::commit();
            return redirect()->route('inventories.index')
                ->with('success', '商品情報を更新しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            // 新しくアップロードしたファイルが存在する場合は削除
            if (isset($filename)) {
                Storage::delete('drawings/' . $filename);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => '商品情報の更新に失敗しました。']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', '商品を削除しました。');
    }
}

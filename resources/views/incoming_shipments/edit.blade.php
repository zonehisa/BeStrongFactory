<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            入庫情報編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('incoming_shipments.update', $incomingShipment) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="inventory_id" class="block text-gray-700 text-sm font-bold mb-2">商品</label>
                            <div class="text-gray-900">{{ $incomingShipment->inventory->item_name }}</div>
                            <input type="hidden" name="inventory_id" value="{{ $incomingShipment->inventory_id }}">
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">入荷数量</label>
                            <input type="number" name="quantity" id="quantity"
                                value="{{ old('quantity', $incomingShipment->quantity) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('quantity')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="unit" class="block text-gray-700 text-sm font-bold mb-2">単位</label>
                            <input type="text" name="unit" id="unit"
                                value="{{ old('unit', $incomingShipment->unit) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('unit')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="unit_price" class="block text-gray-700 text-sm font-bold mb-2">単価</label>
                            <input type="number" step="0.01" name="unit_price" id="unit_price"
                                value="{{ old('unit_price', $incomingShipment->unit_price) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('unit_price')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="supplier_name" class="block text-gray-700 text-sm font-bold mb-2">仕入先</label>
                            <input type="text" name="supplier_name" id="supplier_name"
                                value="{{ old('supplier_name', $incomingShipment->supplier_name) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('supplier_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="lot_number" class="block text-gray-700 text-sm font-bold mb-2">ロット番号</label>
                            <input type="text" name="lot_number" id="lot_number"
                                value="{{ old('lot_number', $incomingShipment->lot_number) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('lot_number')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="received_date" class="block text-gray-700 text-sm font-bold mb-2">入荷日</label>
                            <input type="date" name="received_date" id="received_date"
                                value="{{ old('received_date', $incomingShipment->received_date->format('Y-m-d')) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('received_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">ステータス</label>
                            <select name="status" id="status"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="pending"
                                    {{ old('status', $incomingShipment->status) === 'pending' ? 'selected' : '' }}>保留中
                                </option>
                                <option value="completed"
                                    {{ old('status', $incomingShipment->status) === 'completed' ? 'selected' : '' }}>完了
                                </option>
                                <option value="cancelled"
                                    {{ old('status', $incomingShipment->status) === 'cancelled' ? 'selected' : '' }}>
                                    キャンセル</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">備考</label>
                            <textarea name="notes" id="notes"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                rows="3">{{ old('notes', $incomingShipment->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                更新
                            </button>
                            <a href="{{ route('incoming_shipments.show', $incomingShipment) }}"
                                class="text-blue-500 hover:text-blue-800">
                                キャンセル
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="flex">
        <x-sidebar class="w-64 bg-blue-900 text-white hidden md:block" />
        <div class="flex-1 p-4 md:p-6 ml-64 mt-16">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-blue-900">
                        <h2 class="font-bold text-gray-900 text-xl p-6">出庫情報編集</h2>
                        <div class="p-6">
                            <form method="POST" action="{{ route('outgoing_shipments.update', $outgoingShipment) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="inventory_id"
                                        class="block text-gray-700 text-sm font-bold mb-2">商品</label>
                                    <div class="text-gray-900">{{ $outgoingShipment->inventory->item_name }}</div>
                                    <input type="hidden" name="inventory_id"
                                        value="{{ $outgoingShipment->inventory_id }}">
                                </div>

                                <div class="mb-4">
                                    <label for="quantity"
                                        class="block text-gray-700 text-sm font-bold mb-2">出庫数量</label>
                                    <input type="number" name="quantity" id="quantity"
                                        value="{{ old('quantity', $outgoingShipment->quantity) }}"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('quantity')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="customer_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">顧客名</label>
                                    <input type="text" name="customer_name" id="customer_name"
                                        value="{{ old('customer_name', $outgoingShipment->customer_name) }}"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="order_number"
                                        class="block text-gray-700 text-sm font-bold mb-2">注文番号</label>
                                    <input type="text" name="order_number" id="order_number"
                                        value="{{ old('order_number', $outgoingShipment->order_number) }}"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('order_number')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="shipped_date"
                                        class="block text-gray-700 text-sm font-bold mb-2">出荷日</label>
                                    <input type="date" name="shipped_date" id="shipped_date"
                                        value="{{ old('shipped_date', $outgoingShipment->shipped_date->format('Y-m-d')) }}"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('shipped_date')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="status"
                                        class="block text-gray-700 text-sm font-bold mb-2">ステータス</label>
                                    <select name="status" id="status"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="pending"
                                            {{ old('status', $outgoingShipment->status) === 'pending' ? 'selected' : '' }}>
                                            保留中
                                        </option>
                                        <option value="completed"
                                            {{ old('status', $outgoingShipment->status) === 'completed' ? 'selected' : '' }}>
                                            完了
                                        </option>
                                        <option value="cancelled"
                                            {{ old('status', $outgoingShipment->status) === 'cancelled' ? 'selected' : '' }}>
                                            キャンセル
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">備考</label>
                                    <textarea name="notes" id="notes"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        rows="3">{{ old('notes', $outgoingShipment->notes) }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        更新
                                    </button>
                                    <a href="{{ route('outgoing_shipments.show', $outgoingShipment) }}"
                                        class="text-blue-500 hover:text-blue-800">
                                        キャンセル
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

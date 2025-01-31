<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            入庫登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('incoming_shipments.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="inventory_id" class="block text-gray-700 text-sm font-bold mb-2">商品</label>
                            <select name="inventory_id" id="inventory_id" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">選択してください</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}"
                                        {{ old('inventory_id', $selectedInventoryId) == $inventory->id ? 'selected' : '' }}>
                                        {{ $inventory->item_name }}
                                        (現在庫: {{ $inventory->current_stock }}個
                                        @if ($inventory->package_quantity > 1)
                                            、発注ロット: {{ $inventory->package_quantity }}個/パッケージ
                                        @endif)
                                    </option>
                                @endforeach
                            </select>
                            @error('inventory_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">入庫数量</label>
                            <input type="number" name="quantity" id="quantity" min="1" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('quantity') }}">
                            @error('quantity')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="supplier_name" class="block text-gray-700 text-sm font-bold mb-2">仕入先</label>
                            <input type="text" name="supplier_name" id="supplier_name" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('supplier_name', $selectedInventoryId && $inventories->isNotEmpty() ? $inventories->find($selectedInventoryId)->supplier_name : '') }}">
                            @error('supplier_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                入庫する
                            </button>
                            <a href="{{ route('inventories.index') }}" class="text-blue-500 hover:text-blue-800">
                                キャンセル
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            出庫登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('outgoing_shipments.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="inventory_id" class="block text-gray-700 text-sm font-bold mb-2">商品</label>
                            <select name="inventory_id" id="inventory_id" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">選択してください</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}"
                                        data-current-stock="{{ $inventory->current_stock }}"
                                        {{ $selectedInventoryId == $inventory->id ? 'selected' : '' }}>
                                        {{ $inventory->item_name }}
                                        (在庫: {{ $inventory->current_stock }}個)
                                    </option>
                                @endforeach
                            </select>
                            @error('inventory_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">出庫数量</label>
                            <div class="flex items-center">
                                <input type="number" name="quantity" id="quantity" min="1" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <span class="ml-2" id="stock-warning" class="text-red-500"></span>
                            </div>
                            @error('quantity')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" id="submit-button"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                出庫する
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

    @push('scripts')
        <script>
            const quantityInput = document.getElementById('quantity');
            const inventorySelect = document.getElementById('inventory_id');
            const stockWarning = document.getElementById('stock-warning');
            const submitButton = document.getElementById('submit-button');

            function updateWarning() {
                const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
                if (!selectedOption.value) return;

                const currentStock = parseInt(selectedOption.dataset.currentStock);
                const inputQuantity = parseInt(quantityInput.value) || 0;

                if (inputQuantity > currentStock) {
                    stockWarning.textContent = `※ 在庫不足です（在庫: ${currentStock}個）`;
                    stockWarning.classList.add('text-red-500');
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (inputQuantity > 0) {
                    stockWarning.textContent = `（残り: ${currentStock - inputQuantity}個）`;
                    stockWarning.classList.remove('text-red-500');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    stockWarning.textContent = '';
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            inventorySelect.addEventListener('change', updateWarning);
            quantityInput.addEventListener('input', updateWarning);

            // 初期表示時にも情報を更新
            if (inventorySelect.value) {
                updateWarning();
            }
        </script>
    @endpush
</x-app-layout>

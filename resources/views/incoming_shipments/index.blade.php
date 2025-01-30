<x-app-layout>
    <div class="flex">

        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        商品名</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        在庫数</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        最小在庫数</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        発注ロット</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        操作</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select id="inventory-select" class="rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="">商品を選択してください</option>
                                            @foreach ($inventories as $inventory)
                                                <option value="{{ $inventory->id }}" 
                                                    data-current-stock="{{ $inventory->current_stock }}"
                                                    data-minimum-stock="{{ $inventory->minimum_stock }}"
                                                    data-package-quantity="{{ $inventory->package_quantity }}">
                                                    {{ $inventory->item_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" id="current-stock">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap" id="minimum-stock">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap" id="package-quantity">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('incoming_shipments.create') }}"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">入荷登録</a>
                                    </td>
                                </tr>

                                <script>
                                    document.getElementById('inventory-select').addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];
                                        
                                        if (selectedOption.value) {
                                            document.getElementById('current-stock').textContent = selectedOption.getAttribute('data-current-stock');
                                            document.getElementById('minimum-stock').textContent = selectedOption.getAttribute('data-minimum-stock');
                                            document.getElementById('package-quantity').textContent = selectedOption.getAttribute('data-package-quantity');
                                        } else {
                                            document.getElementById('current-stock').textContent = '-';
                                            document.getElementById('minimum-stock').textContent = '-';
                                            document.getElementById('package-quantity').textContent = '-';
                                        }
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

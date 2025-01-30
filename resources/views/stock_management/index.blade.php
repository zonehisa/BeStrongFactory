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
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select id="inventory-select"
                                            class="rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
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
                                </tr>

                                <tr>
                                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-center">
                                        <div class="flex justify-center gap-8">
                                            <a href="#" id="incoming-link" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg">
                                                入庫
                                            </a>
                                            <a href="#" id="outgoing-link" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg text-lg">
                                                出庫
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <script>
                                    const inventorySelect = document.getElementById('inventory-select');
                                    const incomingLink = document.getElementById('incoming-link');
                                    const outgoingLink = document.getElementById('outgoing-link');
                                    // 初期状態ではリンクを無効化
                                    incomingLink.classList.add('opacity-50', 'cursor-not-allowed');
                                    outgoingLink.classList.add('opacity-50', 'cursor-not-allowed');
                                    inventorySelect.addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];

                                        if (selectedOption.value) {
                                            document.getElementById('current-stock').textContent = selectedOption.getAttribute(
                                                'data-current-stock');
                                            document.getElementById('minimum-stock').textContent = selectedOption.getAttribute(
                                                'data-minimum-stock');
                                            document.getElementById('package-quantity').textContent = selectedOption.getAttribute(
                                                'data-package-quantity');

                                            // 商品が選択されたらリンクを有効化し、URLを設定
                                            incomingLink.classList.remove('opacity-50', 'cursor-not-allowed');
                                            incomingLink.href = "{{ route('incoming_shipments.create') }}?inventory_id=" + selectedOption.value;
                                            outgoingLink.classList.remove('opacity-50', 'cursor-not-allowed');
                                            outgoingLink.href = "{{ route('outgoing_shipments.create') }}?inventory_id=" + selectedOption.value;
                                        } else {
                                            document.getElementById('current-stock').textContent = '-';
                                            document.getElementById('minimum-stock').textContent = '-';
                                            document.getElementById('package-quantity').textContent = '-';

                                            // 商品が選択されていない場合はリンクを無効化
                                            incomingLink.classList.add('opacity-50', 'cursor-not-allowed');
                                            incomingLink.href = '#';
                                            outgoingLink.classList.add('opacity-50', 'cursor-not-allowed');
                                            outgoingLink.href = '#';
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

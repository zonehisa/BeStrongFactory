<x-app-layout>
    <div class="flex">
        <div class="w-64 h-screen bg-gray-800 text-white">
            <ul>
                <li>
                    <a href="#" class="block p-4 hover:bg-gray-700 relative">注文管理</a>
                </li>
                <li>
                    <a href="{{ route('inventories.index') }}" class="block p-4 hover:bg-gray-700 relative">材料マスター</a>
                </li>
            </ul>
        </div>
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        品番
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        商品名
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        現在庫
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        最小在庫数
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        パッケージ数量
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        操作
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $inventory->item_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $inventory->item_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $inventory->current_stock }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $inventory->minimum_stock }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $inventory->package_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('incoming_shipments.create', ['inventory_id' => $inventory->id]) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">入庫登録</a>
                                            <a href="{{ route('outgoing_shipments.create', ['inventory_id' => $inventory->id]) }}"
                                                class="text-green-600 hover:text-green-900">出庫登録</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

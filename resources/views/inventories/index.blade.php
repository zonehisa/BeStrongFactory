<x-app-layout>
    <div class="flex">
        <x-sidebar />
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                @if ($lowStockItems->isNotEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">
                            <i class="fas fa-exclamation-triangle"></i> 注意
                        </strong>
                        
                        <ul>
                            @foreach ($lowStockItems as $item)
                                <li class="font-bold text-lg text-red-500">{{ $item->item_name }} (在庫数: {{ $item->current_stock }})</li>
                            @endforeach
                        </ul>
                        <span class="block sm:inline">上記の商品が安全在庫を下回っています。発注をご検討ください。</span>
                    </div>
                @endif
            </div>
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
                                        安全在庫
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
                                            <a href="{{ route('inventories.show', ['inventory' => $inventory->id]) }}">
                                                {{ $inventory->item_code }}
                                            </a>
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

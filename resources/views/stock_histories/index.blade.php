<x-app-layout>
    <div class="flex">
        <x-sidebar class="w-64 bg-blue-900 text-white hidden md:block" />
        <div class="flex-1 p-4 md:p-6 ml-64">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">在庫履歴一覧</h2>
                        <!-- フィルターフォーム -->
                        <form method="GET" action="{{ route('stock_histories.index') }}"
                            class="mb-6 bg-gray-50 p-4 rounded">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left text-sm font-medium text-gray-700 pb-2">商品</th>
                                        <th class="text-left text-sm font-medium text-gray-700 pb-2">変動タイプ</th>
                                        <th class="text-left text-sm font-medium text-gray-700 pb-2">日付（から）</th>
                                        <th class="text-left text-sm font-medium text-gray-700 pb-2">日付（まで）</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pr-4">
                                            <select name="inventory_id" id="inventory_id"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                                <option value="">すべて</option>
                                                @foreach ($inventories as $inventory)
                                                    <option value="{{ $inventory->id }}"
                                                        {{ request('inventory_id') == $inventory->id ? 'selected' : '' }}>
                                                        {{ $inventory->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="pr-4">
                                            <select name="movement_type" id="movement_type"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                                <option value="">すべて</option>
                                                <option value="incoming"
                                                    {{ request('movement_type') === 'incoming' ? 'selected' : '' }}>
                                                    入庫</option>
                                                <option value="outgoing"
                                                    {{ request('movement_type') === 'outgoing' ? 'selected' : '' }}>
                                                    出庫</option>
                                            </select>
                                        </td>
                                        <td class="pr-4">
                                            <input type="date" name="date_from" id="date_from"
                                                value="{{ request('date_from') }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                        </td>
                                        <td class="pr-4">
                                            <input type="date" name="date_to" id="date_to"
                                                value="{{ request('date_to') }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-4 flex justify-end space-x-4">
                                <a href="{{ route('stock_histories.index') }}"
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    リセット
                                </a>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                    検索
                                </button>
                            </div>
                        </form>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        商品ID
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        商品名
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        変動タイプ
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        数量
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        取引先
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        担当者
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        日時
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($stockHistories as $history)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $history->inventory->item_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $history->inventory->item_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($history->movement_type === 'incoming')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">入庫</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">出庫</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($history->movement_type === 'incoming')
                                                +{{ $history->stock_quantity }}
                                            @else
                                                -{{ $history->stock_quantity }}
                                            @endif
                                            個
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($history->movement_type === 'incoming')
                                                {{ $history->reference->supplier_name ?? '' }}
                                            @else
                                                {{ $history->reference->customer_name ?? '' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $history->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $history->record_date->format('Y/m/d H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($stockHistories->isEmpty())
                            <div class="text-center py-4 text-gray-500">
                                在庫履歴がありません
                            </div>
                        @endif

                        <div class="mt-4">
                            {{ $stockHistories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

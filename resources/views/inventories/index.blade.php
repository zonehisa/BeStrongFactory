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
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->item_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->current_stock }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->minimum_stock }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->package_quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('inventories.edit', $inventory) }}"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">編集</a>
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

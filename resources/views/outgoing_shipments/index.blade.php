<x-app-layout>
    <div class="flex">
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">出庫履歴一覧</h2>
                            <a href="{{ route('outgoing_shipments.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                新規出庫登録
                            </a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        出庫日時
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        商品名
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        出庫数
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        担当者
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($outgoingShipments as $shipment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $shipment->created_at->format('Y/m/d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $shipment->inventory->item_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $shipment->quantity }}個
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $shipment->user->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($outgoingShipments->isEmpty())
                            <div class="text-center py-4 text-gray-500">
                                出庫履歴がありません
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

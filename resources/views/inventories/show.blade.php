<x-app-layout>
    <div class="flex">
        <x-sidebar class="w-64 bg-blue-900 text-white hidden md:block" />
        <div class="flex-1 p-4 md:p-6 ml-64 mt-16">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- 基本情報 -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">基本情報</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-bold text-gray-600">品番</p>
                            <p>{{ $inventory->item_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">商品名</p>
                            <p>{{ $inventory->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">現在庫数</p>
                            <p>{{ $inventory->current_stock }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">安全在庫数</p>
                            <p>{{ $inventory->minimum_stock }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">パッケージ数量</p>
                            <p>{{ $inventory->package_quantity }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">仕入先</p>
                            <p>{{ $inventory->supplier_name ?: '未設定' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">顧客</p>
                            <p>{{ $inventory->customer_name ?: '未設定' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">仕入れ価格</p>
                            <p>{{ $inventory->purchase_price ? '¥' . number_format($inventory->purchase_price) : '未設定' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">販売価格</p>
                            <p>{{ $inventory->selling_price ? '¥' . number_format($inventory->selling_price) : '未設定' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600">納期（日数）</p>
                            <p>{{ $inventory->lead_time ? $inventory->lead_time . '日' : '未設定' }}</p>
                        </div>
                    </div>

                    @if ($inventory->drawing_file)
                        <div class="mt-4">
                            <p class="text-sm font-bold text-gray-600">図面</p>
                            <img src="{{ Storage::url('drawings/' . $inventory->drawing_file) }}" alt="商品図面"
                                class="max-w-md mt-2">
                        </div>
                    @endif

                    @if ($inventory->notes)
                        <div class="mt-4">
                            <p class="text-sm font-bold text-gray-600">備考</p>
                            <p class="whitespace-pre-wrap">{{ $inventory->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 在庫履歴 -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">在庫履歴</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    日時
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    取引先
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    処理
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    数量
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    在庫数
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    担当者
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($inventory->stockHistories()->latest()->paginate(3) as $history)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $history->created_at->format('Y/m/d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($history->movement_type === 'incoming')
                                            {{ $history->reference->supplier_name ?? '' }}
                                        @else
                                            {{ $history->reference->customer_name ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($history->movement_type === 'incoming')
                                            <span class="text-green-600">入庫</span>
                                        @else
                                            <span class="text-red-600">出庫</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($history->movement_type === 'incoming')
                                            +{{ $history->reference->quantity ?? 0 }}
                                        @else
                                            -{{ $history->reference->quantity ?? 0 }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $history->stock_quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $history->user->name ?? '不明' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $inventory->stockHistories()->latest()->paginate(3)->links() }}

                    @if ($inventory->stockHistories->isEmpty())
                        <div class="text-center py-4 text-gray-500">
                            在庫履歴がありません
                        </div>
                    @endif
                </div>
            </div>

            <!-- 操作ボタン -->
            <div class="mt-6 flex justify-between">
                <div>
                    <a href="{{ route('inventories.edit', $inventory) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                        編集
                    </a>
                </div>
                <a href="{{ route('inventories.index') }}"
                    class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4">
                    戻る
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

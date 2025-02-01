<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            出庫詳細
        </h2>
    </x-slot>

    <div class="flex">
        <x-sidebar />
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <a href="{{ route('outgoing_shipments.index') }}" class="text-blue-600 hover:text-blue-800">←
                                出庫一覧に戻る</a>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="font-bold">商品名:</div>
                            <div>{{ $outgoingShipment->inventory->item_name }}</div>

                            <div class="font-bold">出庫数量:</div>
                            <div>{{ $outgoingShipment->quantity }}個</div>

                            <div class="font-bold">顧客名:</div>
                            <div>{{ $outgoingShipment->customer_name ?? '未設定' }}</div>

                            <div class="font-bold">注文番号:</div>
                            <div>{{ $outgoingShipment->order_number ?? '未設定' }}</div>

                            <div class="font-bold">出荷日:</div>
                            <div>{{ $outgoingShipment->shipped_date->format('Y/m/d') }}</div>

                            <div class="font-bold">ステータス:</div>
                            <div>
                                @switch($outgoingShipment->status)
                                    @case('pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">保留中</span>
                                    @break

                                    @case('completed')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">完了</span>
                                    @break

                                    @case('cancelled')
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded">キャンセル</span>
                                    @break

                                    @default
                                        <span
                                            class="bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $outgoingShipment->status }}</span>
                                @endswitch
                            </div>

                            <div class="font-bold">担当者:</div>
                            <div>{{ $outgoingShipment->user->name }}</div>

                            <div class="font-bold">備考:</div>
                            <div>{{ $outgoingShipment->notes ?? '無し' }}</div>
                        </div>

                        <div class="mt-6 flex gap-4">
                            @if ($outgoingShipment->status === 'pending')
                                <a href="{{ route('outgoing_shipments.edit', $outgoingShipment) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    編集
                                </a>
                                <form action="{{ route('outgoing_shipments.destroy', $outgoingShipment) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('本当に削除しますか？')">
                                        削除
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

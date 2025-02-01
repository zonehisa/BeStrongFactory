<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            入庫詳細
        </h2>
    </x-slot>

    <div class="flex">
        <x-sidebar />
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('incoming_shipments.index') }}" class="text-blue-600 hover:text-blue-800">←
                            入庫一覧に戻る</a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="font-bold">商品名:</div>
                        <div>{{ $incomingShipment->inventory->item_name }}</div>

                        <div class="font-bold">入荷数量:</div>
                        <div>{{ $incomingShipment->quantity }} {{ $incomingShipment->unit }}</div>

                        <div class="font-bold">単価:</div>
                        <div>
                            {{ $incomingShipment->unit_price ? '¥' . number_format($incomingShipment->unit_price, 2) : '未設定' }}
                        </div>

                        <div class="font-bold">仕入先:</div>
                        <div>{{ $incomingShipment->supplier_name ?? '未設定' }}</div>

                        <div class="font-bold">ロット番号:</div>
                        <div>{{ $incomingShipment->lot_number ?? '未設定' }}</div>

                        <div class="font-bold">入荷日:</div>
                        <div>{{ $incomingShipment->received_date->format('Y/m/d') }}</div>

                        <div class="font-bold">ステータス:</div>
                        <div>
                            @switch($incomingShipment->status)
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
                                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $incomingShipment->status }}</span>
                            @endswitch
                        </div>

                        <div class="font-bold">担当者:</div>
                        <div>{{ $incomingShipment->user->name }}</div>

                        <div class="font-bold">備考:</div>
                        <div>{{ $incomingShipment->notes ?? '無し' }}</div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        @if ($incomingShipment->status === 'pending')
                            <a href="{{ route('incoming_shipments.edit', $incomingShipment) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                編集
                            </a>
                            <form action="{{ route('incoming_shipments.destroy', $incomingShipment) }}" method="POST"
                                class="inline">
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
</x-app-layout>

<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">在庫詳細</h1>

                    @if($inventory->drawing_file)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">図面ファイル:</h2>
                        <img src="{{ asset('storage/drawings/' . $inventory->drawing_file) }}" alt="図面" class="max-w-xl">
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">品番:</p>
                            <p>{{ $inventory->item_code }}</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">商品名:</p>
                            <p>{{ $inventory->item_name }}</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">仕入先:</p>
                            <p>{{ $inventory->supplier_name }}</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">顧客:</p>
                            <p>{{ $inventory->customer_name }}</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">仕入れ価格:</p>
                            <p>{{ $inventory->purchase_price }}円</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">販売価格:</p>
                            <p>{{ $inventory->selling_price }}円</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">納期:</p>
                            <p>{{ $inventory->lead_time }}日</p>
                        </div>

                        <div class="border rounded p-4">
                            <p class="font-semibold mb-1">在庫数:</p>
                            <p>{{ $inventory->current_stock }}個</p>
                        </div>
                    </div>

                    <div class="border rounded p-4 mb-6">
                        <p class="font-semibold mb-1">備考:</p>
                        <p>{{ $inventory->notes }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('inventories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            一覧に戻る
                        </a>
                        <a href="{{ route('inventories.edit', $inventory->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            編集
                        </a>
                        <a href="{{ route('inventories.destroy', $inventory->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            削除
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

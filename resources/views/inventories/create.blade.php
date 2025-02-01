<x-app-layout>
    <div class="flex">
        <x-sidebar class="w-64 bg-blue-900 text-white hidden md:block" />
        <div class="flex-1 p-4 md:p-6 ml-64 mt-16">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">在庫マスター登録</h2>
                            <form method="POST" action="{{ route('inventories.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="item_code" class="block text-gray-700 text-sm font-bold mb-2">品番</label>
                                    <input type="text" name="item_code" id="item_code" required
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('item_code') }}">
                                    @error('item_code')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="item_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">商品名</label>
                                    <input type="text" name="item_name" id="item_name" required
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('item_name') }}">
                                    @error('item_name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="minimum_stock"
                                        class="block text-gray-700 text-sm font-bold mb-2">安全在庫</label>
                                    <input type="number" name="minimum_stock" id="minimum_stock" min="0"
                                        required
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('minimum_stock', 0) }}">
                                    @error('minimum_stock')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="package_quantity"
                                        class="block text-gray-700 text-sm font-bold mb-2">パッケージ数量</label>
                                    <input type="number" name="package_quantity" id="package_quantity" min="1"
                                        required
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('package_quantity', 1) }}">
                                    @error('package_quantity')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="supplier_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">仕入先</label>
                                    <input type="text" name="supplier_name" id="supplier_name"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('supplier_name') }}">
                                    @error('supplier_name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="customer_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">顧客</label>
                                    <input type="text" name="customer_name" id="customer_name"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="purchase_price"
                                        class="block text-gray-700 text-sm font-bold mb-2">仕入れ価格</label>
                                    <input type="number" name="purchase_price" id="purchase_price" step="0.01"
                                        min="0"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('purchase_price') }}">
                                    @error('purchase_price')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="selling_price"
                                        class="block text-gray-700 text-sm font-bold mb-2">販売価格</label>
                                    <input type="number" name="selling_price" id="selling_price" step="0.01"
                                        min="0"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('selling_price') }}">
                                    @error('selling_price')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="lead_time"
                                        class="block text-gray-700 text-sm font-bold mb-2">納期（日数）</label>
                                    <input type="number" name="lead_time" id="lead_time" min="0"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('lead_time') }}">
                                    @error('lead_time')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="drawing_file"
                                        class="block text-gray-700 text-sm font-bold mb-2">図面ファイル</label>
                                    <input type="file" name="drawing_file" id="drawing_file" accept="image/*"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('drawing_file')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="notes"
                                        class="block text-gray-700 text-sm font-bold mb-2">備考</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        登録
                                    </button>
                                    <a href="{{ route('inventories.index') }}"
                                        class="text-blue-500 hover:text-blue-800">
                                        キャンセル
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>

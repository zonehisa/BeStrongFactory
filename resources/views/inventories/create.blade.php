<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            在庫新規登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('inventories.store') }}">
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
                            <label for="item_name" class="block text-gray-700 text-sm font-bold mb-2">商品名</label>
                            <input type="text" name="item_name" id="item_name" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('item_name') }}">
                            @error('item_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="minimum_stock" class="block text-gray-700 text-sm font-bold mb-2">最小在庫数</label>
                            <input type="number" name="minimum_stock" id="minimum_stock" min="0" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('minimum_stock', 0) }}">
                            @error('minimum_stock')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="package_quantity"
                                class="block text-gray-700 text-sm font-bold mb-2">パッケージ数量</label>
                            <input type="number" name="package_quantity" id="package_quantity" min="1" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('package_quantity', 1) }}">
                            @error('package_quantity')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                登録
                            </button>
                            <a href="{{ route('inventories.index') }}" class="text-blue-500 hover:text-blue-800">
                                キャンセル
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

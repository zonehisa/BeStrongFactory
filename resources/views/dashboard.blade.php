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
                <li>
                    <a href="#" class="block p-4 hover:bg-gray-700">取引先管理</a>
                </li>
            </ul>
        </div>
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        ここに在庫の情報や、注文の情報などを表示する
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        ここに在庫の情報や、注文の情報などを表示する
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

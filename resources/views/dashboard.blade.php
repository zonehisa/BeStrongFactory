<x-app-layout>
    <div class="flex min-h-screen">
        <!-- サイドバー -->
        <x-sidebar class="w-64 bg-blue-900 text-white hidden md:block" />

        <!-- メインコンテンツ -->
        <div class="flex-1 p-4 md:p-6 ml-64">
            <div class="text-2xl font-bold text-gray-800 leading-tight">ダッシュボード</div>

            <!-- コンテンツカード -->
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 mt-6 space-y-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <p class="text-gray-900">ここに在庫の情報や、注文の情報などを表示する</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <p class="text-gray-900">ここに在庫の情報や、注文の情報などを表示する</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

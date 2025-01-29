<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex">
        <div class="w-64 h-screen bg-gray-800 text-white">
            <ul>
                <li class="p-4 hover:bg-gray-700"><a href="#">内示管理</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="#">製品管理</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="#">ユーザー管理</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="#">設定</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="#">ログアウト</a></li>
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

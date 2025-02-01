<div class="fixed mt-16 w-64 h-screen bg-blue-900 text-white">
    <ul class="font-bold">
        <li>
            <a href="{{ route('inventories.index') }}"
                class="block p-6 hover:bg-blue-700 hover:translate-x-4 transition-transform duration-200">在庫管理</a>
        </li>
        <li>
            <a href="{{ route('inventories.create') }}"
                class="block p-6 hover:bg-blue-700 hover:translate-x-4 transition-transform duration-200">在庫マスター登録</a>
        </li>
        <li>
            <a href="{{ route('stock_histories.index') }}"
                class="block p-6 hover:bg-blue-700 hover:translate-x-4 transition-transform duration-200">入出庫履歴</a>
        </li>
    </ul>
</div>

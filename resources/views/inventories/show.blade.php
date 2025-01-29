<x-app-layout>
    <h1>在庫詳細</h1>
    <p>商品名: {{ $inventory->name }}</p>
    <p>在庫数: {{ $inventory->quantity }}</p>

    <a href="{{ route('inventories.index') }}">一覧に戻る</a>
</x-app-layout>

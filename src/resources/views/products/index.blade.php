@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/inidex.css')}}">
@endsection

@section('content')
<h1>商品一覧</h1>

<!-- 検索フォーム -->
<form method="GET" action="{{ route('products.index') }}">
    <label for="search">商品名で検索</label>
    <input type="text" name="keyword" id="search" value="{{ request('keyword') }}">
    <label for="sort">価格順</label>
    <select name="sort" id="sort">
        <option value="">-- 選択 --</option>
        <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>価格が安い順</option>
        <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>価格が高い順</option>
    </select>

    <button type="submit">検索</button>
    <a href="{{ route('products.index') }}"><button type="button">リセット</button></a>
</form>

<!-- 商品一覧 -->
@foreach ($products as $product)
    <div class="card">
        <h2>{{ $product->name }}</h2>
        <p>価格：¥{{ number_format($product->price) }}</p>
        <p>季節：{{ $product->seasons->pluck('name')->join(', ') }}</p>
        <p>{{ Str::limit($product->description, 60) }}</p>
        @if ($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="max-width: 200px;">
        @endif
        <div>
            <a href="{{ route('products.show', $product) }}">
                <button type="button">詳細</button>
            </a>
        </div>
    </div>
@endforeach

<!-- ページネーション -->
{{ $products->links() }}

<!-- 商品追加ボタン -->
<div style="margin-top: 30px;">
    <a href="{{ route('products.create') }}">
        <button>＋ 商品を追加</button>
    </a>
</div>
@endsection

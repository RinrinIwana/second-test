@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-list-page">
    <div class="product-list-page__header">
        <h1 class="product-list-page__title">商品一覧</h1>
        <a href="{{ route('products.create') }}" class="product-list-page__add-button">＋ 商品を追加</a>
    </div>

    <div class="product-list-page__body">
        <!-- 左サイドバー -->
        <aside class="product-list-page__sidebar">
            <form method="GET" action="{{ route('products.index') }}" class="product-filter">
                <label for="keyword" class="product-filter__label">商品名で検索</label>
                <input type="text" name="keyword" id="keyword" class="product-filter__input" placeholder="商品名で検索" value="{{ request('keyword') }}">

                <button type="submit" class="product-filter__button">検索</button>

                <label for="sort" class="product-filter__label">価格順で表示</label>
                <select name="sort" id="sort" class="product-filter__select">
                    <option value="">価格で並べ替え</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>価格が安い順</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>価格が高い順</option>
                </select>
            </form>
        </aside>

        <!-- 商品一覧 -->
        <section class="product-list-page__main">
            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-card">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-card__image">
                    @endif
                    <div class="product-card__info">
                        <h2 class="product-card__name">{{ $product->name }}</h2>
                        <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                        {{-- 季節や説明なども追加可能 --}}
                    </div>
                    <a href="{{ route('products.edit', $product) }}" class="product-card__button">詳細</a>
                </div>
                @endforeach
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </section>
    </div>
</div>
@endsection
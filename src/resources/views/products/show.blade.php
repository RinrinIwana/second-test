@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>
<p>価格：¥{{ number_format($product->price) }}</p>
<p>説明：{{ $product->description }}</p>
@if ($product->image_path)
    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="max-width: 300px;">
@endif
<p>季節：{{ $product->seasons->pluck('name')->join(', ') }}</p>

<a href="{{ route('products.index') }}">一覧へ戻る</a>
@endsection
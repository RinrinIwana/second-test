@extends('layouts.app')

@section('title', '商品編集')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="form-container">
    <h1 class="form-title">商品情報を編集</h1>

    @if ($errors->any())
        <ul class="error-messages">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf

        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
        @error('name')<p class="error">{{ $message }}</p>@enderror

        <label>値段</label>
        <input type="text" name="price" value="{{ old('price', $product->price) }}">
        @error('price')<p class="error">{{ $message }}</p>@enderror

        <label>季節</label>
        <div class="checkboxes">
            @foreach($seasons as $season)
                <label>
                    <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                        {{ in_array($season->id, old('season_ids', $productSeasons)) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
            @endforeach
        </div>
        @error('season_ids')<p class="error">{{ $message }}</p>@enderror

        <label>商品説明</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
        @error('description')<p class="error">{{ $message }}</p>@enderror

        <label>商品画像</label>
        @if($product->image)
            <div class="image-preview">
                <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="100">
            </div>
        @endif
        <input type="file" name="image">
        @error('image')<p class="error">{{ $message }}</p>@enderror

        <div class="form-actions">
            <button type="submit" class="submit-button">変更を保存</button>
            <a href="{{ route('products.index') }}" class="back-button">戻る</a>
        </div>
    </form>

    <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button" title="削除">
            🗑️ {{-- ゴミ箱アイコン素材は後ほど差し替え --}}
        </button>
    </form>
</div>
@endsection

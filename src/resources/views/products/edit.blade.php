@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="product-edit">
    <div class="product-edit__breadcrumb">
        <a href="{{ route('products.index') }}" class="product-edit__link">商品一覧</a> ＞ {{ $product->name }}
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-edit__form">
        @csrf
        <div class="product-edit__container">
            <!-- 左カラム -->
            <div class="product-edit__image-section">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-edit__image">
                <input type="file" name="image" class="product-edit__file-input">
                @error('image')
                    <div class="product-edit__error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 右カラム -->
            <div class="product-edit__fields">
                <div class="product-edit__field">
                    <label for="name" class="product-edit__label">商品名</label>
                    <input type="text" name="name" id="name" class="product-edit__input" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="product-edit__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="product-edit__field">
                    <label for="price" class="product-edit__label">値段</label>
                    <input type="number" name="price" id="price" class="product-edit__input" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="product-edit__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="product-edit__field">
                    <label class="product-edit__label">季節</label>
                    <div class="product-edit__checkbox-group">
                        @foreach ($seasons as $season)
                            <label class="product-edit__checkbox">
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                    {{ $product->seasons->pluck('id')->contains($season->id) ? 'checked' : '' }}>
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('seasons')
                        <div class="product-edit__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 商品説明 -->
        <div class="product-edit__field product-edit__description">
            <label for="description" class="product-edit__label">商品説明</label>
            <textarea name="description" id="description" class="product-edit__textarea">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="product-edit__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- ボタン -->
        <div class="product-edit__buttons">
            <a href="{{ route('products.index') }}" class="product-edit__button product-edit__button--gray">戻る</a>
            <button type="submit" class="product-edit__button product-edit__button--yellow">変更を保存</button>

        </div>
    </form>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="product-edit__delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="product-edit__delete-button" onclick="return confirm('本当に削除しますか？')">
        <img src="{{ asset('images/delete-icon.svg') }}" alt="削除" class="product-edit__delete-icon">
        </button>
    </form>
</div>
@endsection
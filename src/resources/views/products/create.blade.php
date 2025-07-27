@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="product-form">
    <h1 class="product-form__title">商品登録</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form__form">
        @csrf

        <!-- 商品名 -->
        <div class="product-form__group">
            <label for="name" class="product-form__label">商品名 <span class="product-form__required">必須</span></label>
            <input type="text" id="name" name="name" class="product-form__input" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
                <div class="product-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 値段 -->
        <div class="product-form__group">
            <label for="price" class="product-form__label">値段 <span class="product-form__required">必須</span></label>
            <input type="number" id="price" name="price" class="product-form__input" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
                <div class="product-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品画像 -->
        <div class="product-form__group">
            <label for="image" class="product-form__label">商品画像 <span class="product-form__required">必須</span></label>
            <input type="file" id="image" name="image" class="product-form__input" accept="image/png, image/jpeg">
            @error('image')
                <div class="product-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 季節 -->
        <div class="product-form__group">
            <label class="product-form__label">季節 <span class="product-form__required">必須</span> <span class="product-form__note">複数選択可</span></label>
            <div class="product-form__checkbox-group">
                @foreach ($seasons as $season)
                    <label class="product-form__checkbox">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                        {{ is_array(old('seasons')) && in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
                <div class="product-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div class="product-form__group">
            <label for="description" class="product-form__label">商品説明 <span class="product-form__required">必須</span></label>
            <textarea id="description" name="description" class="product-form__textarea" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <div class="product-form__error">{{ $message }}</div>
            @enderror
        </div>

        <!-- ボタン -->
        <div class="product-form__buttons">
            <a href="{{ route('products.index') }}" class="product-form__button product-form__button--gray">戻る</a>
            <button type="submit" class="product-form__button product-form__button--yellow">登録</button>
        </div>
    </form>
</div>
@endsection
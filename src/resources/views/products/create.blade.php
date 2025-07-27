@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css')}}">
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">商品登録</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">商品名</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}">
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="price">値段</label>
    <input type="number" id="price" name="price" value="{{ old('price') }}">
    @error('price')
        <div class="error">{{ $message }}</div>
    @enderror

    <div class="form-group">
        <label>季節</label>
        <div class="season-options">
            @foreach ($seasons as $season)
            <label class="radio-like-checkbox">
                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                {{ is_array(old('seasons')) && in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                <span class="custom-radio"></span>
                {{ $season->name }}
            </label>
            @endforeach
        </div>
    </div>

    <label for="description">商品説明</label>
    <textarea id="description" name="description">{{ old('description') }}</textarea>
    @error('description')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="image">商品画像</label>
    <input type="file" id="image" name="image" accept="image/png, image/jpeg">
    @error('image')
        <div class="error">{{ $message }}</div>
    @enderror

    <input type="submit" value="登録">
    <a href="{{ route('products.index') }}"><button type="button">戻る</button></a>
</form>
</div>
@endsection

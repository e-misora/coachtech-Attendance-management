@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')
<div class="content__inner">
    <div class="content__heading">
        <h2>会員登録</h2>
    </div>
    <form class="content-form" action="/register" method="post">
    @csrf
        <div class="content-form__group">
            <label class="content-form__group--label" for="name">名前</label>
            <input class="content-form__group--input" type="text" name="name" id="name" value="{{old('name')}}">
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="content-form__group">
            <label class="content-form__group--label" for="email">メールアドレス</label>
            <input class="content-form__group--input" type="email" name="email" id="email" value="{{old('email')}}">
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="content-form__group">
            <label class="content-form__group--label" for="password">パスワード</label>
            <input class="content-form__group--input" type="password" name="password" id="password">
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="content-form__group">
            <label class="content-form__group--label" for="">パスワード確認</label>
            <input class="content-form__group--input" type="password" name="password_confirmation">
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="content-form__button">
            <button class="content-form__button--submit">登録する</button>
            <a class="content-form__button--link-login" href="/login">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection
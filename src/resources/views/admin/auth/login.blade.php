@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin_login.css')}}">
@endsection

@section('content')
<div class="content__inner">
    <div class="content__heading">
        <h2>管理者ログイン</h2>
    </div>
    <form class="content-form" action="/admin/login" method="post">
    @csrf
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
        <div class="content-form__button">
            <button class="content-form__button--submit">管理者ログインする</button>
        </div>
    </form>
</div>
@endsection
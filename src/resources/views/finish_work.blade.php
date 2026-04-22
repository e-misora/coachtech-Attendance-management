@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('link')
<nav class="header__link">
        <a class="header__link--attendance" href="/attendance">今月の出勤一覧</a>
        <a class="header__link--request_list" href="/stamp_correction_request/list">申請一覧</a>
    <form action="/logout" method="post">
    @csrf
        <button class="header__link--logout" type="submit">ログアウト</button>
    </form>
</nav>
@endsection

@section('content')
<div class="content__inner">
    <form action="/attendance" method="post">
    @csrf
        <div class="content__heading">
            <p class="content__heading--status">
                退勤済
            </p>
        </div>
        <p class="content__date--now">{{$date}}</p>
        <input type="hidden" name="date" value={{$date}}>
        <p class="content__time--now">{{$time}}</p>
        <input type="hidden" name="start_work_time" value={{$time}}>
        <div class="content-form__button">
            <p class="content__message">お疲れ様でした。</p>
        </div>
    </form>
</div>
@endsection
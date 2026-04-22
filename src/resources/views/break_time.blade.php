@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('link')
<nav class="header__link">
        <a class="header__link--attendance" href="/attendance">勤怠</a>
        <a class="header__link--attendance_list"  href="/attendance/list">勤怠一覧</a>
        <a class="header__link--request_list" href="/stamp_correction_request/list">申請</a>
    <form action="/logout" method="post">
    @csrf
        <button class="header__link--logout" type="submit">ログアウト</button>
    </form>
</nav>
@endsection

@section('content')
<div class="content__inner">
    <form action="/attendance/finish_break" method="post">
    @method('patch')
    @csrf
        <div class="content__heading">
            <p class="content__heading--status">
                休憩中
            </p>
        </div>
        <p class="content__date--now">{{$date}}</p>
        <input type="hidden" name="date" value={{$date}}>
        <p class="content__time--now">{{$time}}</p>
        <input type="hidden" name="start_work_time" value={{$time}}>
        <div class="content-form__button">
            <input class="content-form__button--submit content-form__button--submit-break_time" type="submit" name="finish_break_time" value="休憩戻">
        </div>
    </form>
</div>
@endsection
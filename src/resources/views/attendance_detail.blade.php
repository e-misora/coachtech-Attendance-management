@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance_detail.css')}}">
@endsection

@section('link')
<nav class="header__link">
    <a class="header__link--attendance" href="/attendance">勤怠</a>
    <a class="header__link--attendance_list"  href="/attendance/list">勤怠一覧</a>
    <a class="header__link--request_list" href="/stamp_correction_request/list">申請</a>
    <form class="header__link--logout" action="/logout" method="post">
    @csrf
        ログアウト
    </form>
</nav>
@endsection

@section('content')
<div class="content__inner">
    <div class="content__heading">
        <h2>勤怠詳細</h2>
    </div>
        <form class="content-form" action="{{url('/attendance/detail', $userAttendance->id)}}" method="post">
        @csrf
        <table class="table">
            <tr class="table-row">
                <th class="table-row__header">名前</th>
                <td class="table-row__data">{{$name}}</td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">日付</th>
                <td class="table-row__data">
                    <p>{{$userAttendance->date->isoFormat('YYYY年')}}</p>
                    <p>{{$userAttendance->date->isoFormat('M月D日')}}</p>
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">出勤・退勤</th>
                <td class="table-row__data">
                    <input class="table-row__input--start_work_time" type="text" value="{{$userAttendance->start_work_time->format('H:i')}}" name="start_work_time">
                    <span>〜</span>
                    <input class="table-row__input--finish_work_time" type="text" value="{{$userAttendance->finish_work_time->format('H:i')}}" name="finish_work_time">
                </td>
            </tr>
            <div class="form__error">
                @error('finish_work_time')
                {{ $message }}
                @enderror
            </div>
            @foreach($breakTimes as $breakTime)
            <tr class="table-row">
                <th class="table-row__header">休憩</th>
                <td class="table-row__data">
                    <input class="table-row__input--start_break_time" type="text" value="{{$breakTime->start_break_time?->format('H:i')}}">
                    <span>〜</span>
                    <input class="table-row__input--finish_break_time" type="text" value="{{$breakTime->finish_break_time?->format('H:i')}}">
                </td>
            </tr>
            @php
            $nextItem = $breakTimes->get($breakTime->id + 1);
            $count = 1;
            @endphp
            @if(isset($nextItem))
            <tr class="table-row">
                <th class="table-row__header">休憩{{$count++}}</th>
                <td class="table-row__data">
                    <input class="table-row__input--start_break_time" type="text" value="{{$breakTime->start_break_time?->format('H:i')}}">
                    <span>〜</span>
                    <input class="table-row__input--finish_break_time" type="text" value="{{$breakTime->finish_break_time?->format('H:i')}}">
                </td>
            </tr>
            @endif
            @endforeach
            <tr class="table-row">
                <th class="table-row__header">休憩</th>
                <td class="table-row__data">
                    <input class="table-row__input--start_break_time" type="text">
                    <span>〜</span>
                    <input class="table-row__input--finish_break_time" type="text">
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">備考</th>
                <td class="table-row__data">
                    <textarea class="table-row__data--textarea" name="remarks" rows="3"></textarea>
                </td>
            </tr>
            <tr>
                <div class="form__error">
                @error('remarks')
                {{ $message }}
                @enderror
                </div>
            </tr>
        </table>
        <div class="content-form__button">
            <button class="content-form__button--submit">修正</button>
        </div>
    </form>
</div>
@endsection
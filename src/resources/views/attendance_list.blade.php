@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance_list.css')}}">
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
        <h2>勤怠一覧</h2>
    </div>
    <div class="content__link">
        <a class="content__link--prev_date" href="{{ url('/attendance/list', ['month' => $prevMonth]) }}">
            <span class="content__link--mark">←</span>前月
        </a>
        <div class="content__link--date"><img src="{{asset('images/カレンダーアイコン8.png')}}">{{$month->format('Y/m')}}</div>
        <a class="content__link--next_date" href="{{ route('attendance.index', ['month' => $nextMonth]) }}">
            翌月<span class="content__link--mark">→</span>
        </a>
    </div>
    <table class="table">
        <tr class="table-row__header">
            <th class="table-row__header--label table-row__header--label-date">日付</th>
            <th class="table-row__header--label">出勤</th>
            <th class="table-row__header--label">退勤</th>
            <th class="table-row__header--label">休憩</th>
            <th class="table-row__header--label">合計</th>
            <th class="table-row__header--label">詳細</th>
        <tr>
        @foreach($datePeriod as $date)
        <tr class="table-row__data">
            <td class="table-row__data--date">{{$date->format('m/d')}}({{$date->isoFormat('ddd')}})</td>
            @php
                $userAttendance = $userAttendances->get($date->format('Y-m-d'));
            @endphp
            @if($userAttendance && $userAttendance->breakTime->isNotEmpty())
            <td class="table-row__data--start_work_time">{{$userAttendance->start_work_time->format('H:m')}}</td>
            <td class="table-row__data--finish_work_time">{{$userAttendance->finish_work_time->format('H:m')}}</td>
            @foreach($userAttendance->breakTime as $break)
                <td class="table-row__data--break_time">{{$break->finish_break_time->diff($break->start_break_time)->format('%H:%I')}}</td>
            @endforeach
            <td class="table-row__data--total_time">{{$userAttendance->formatted_total_work_time}}</td>
            <td class="table-row__data--detail">
                <form action="{{url('/attendance/detail/'.$userAttendance->id)}}" method="get">
                @csrf
                    <button class="table-row__button--submit" type="submit">詳細</button>
                </form>
            </td>
            @else
            <td class="table-row__data--start_work_time"></td>
            <td class="table-row__data--finish_work_time"></td>
            <td class="table-row__data--break_time"></td>
            <td class="table-row__data--total_time"></td>
            <td class="table-row__data--detail">
                <form method="get">
                @csrf
                    <button class="table-row__button--submit" type="submit">詳細</button>
                </form>
            </td>
            @endif
            </tr>
        @endforeach
    </table>
</div>
@endsection
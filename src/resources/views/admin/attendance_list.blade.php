@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance_list.css')}}">
@endsection

@section('link')
<nav class="header__link">
    <a class="header__link--attendance_list"  href="/admin/attendance/list">勤怠一覧</a>
    <a class="header__link--attendance" href="/admin/staff/list">スタッフ一覧</a>
    <a class="header__link--request_list" href="/stamp_correction_request/list">申請一覧</a>
    <form class="header__link--logout" action="/admin/logout" method="post">
    @csrf
        ログアウト
    </form>
</nav>
@endsection

@section('content')
<div class="content__inner">
    <div class="content__heading">
        <h2>{{$date->isoFormat('YYYY年M月D日')}}の勤怠</h2>
    </div>
    <div class="content__link">
        <a class="content__link--prev_date" href="{{ url('/admin/attendance/list', ['date' => $prevDate]) }}">
            <span class="content__link--mark">←</span>前日
        </a>
        <div class="content__link--date"><img src="{{asset('images/カレンダーアイコン8.png')}}">{{$date->format('Y/m/d')}}</div>
        <a class="content__link--next_date" href="{{ route('attendance.index', ['date' => $nextDate]) }}">
            翌日<span class="content__link--mark">→</span>
        </a>
    </div>
    <table class="table">
        <tr class="table-row__header">
            <th class="table-row__header--label table-row__header--label-date">名前</th>
            <th class="table-row__header--label">出勤</th>
            <th class="table-row__header--label">退勤</th>
            <th class="table-row__header--label">休憩</th>
            <th class="table-row__header--label">合計</th>
            <th class="table-row__header--label">詳細</th>
        <tr>
        @foreach($userAttendances as $userAttendance)
        @if($userAttendance->date == $date)
        <tr class="table-row__data">
            <td class="table-row__data--date">{{$userAttendance->user?->name}}</td>
            <td class="table-row__data--start_work_time">{{$userAttendance->start_work_time->format('H:i')}}</td>
            <td class="table-row__data--finish_work_time">{{$userAttendance->finish_work_time->format('H:i')}}</td>
            <td class="table-row__data--break_time">1:00</td>
            <td class="table-row__data--total_time">{{$userAttendance->finish_work_time->diff($userAttendance->start_work_time)->format('%H:%I')}}</td>
            <td class="table-row__data--detail">
                <form action="{{url('/admin/detail/'. $userAttendance['id'])}}" method="get">
                @csrf
                    <button class="table-row__button--submit" type="submit">詳細</button>
                </form>
            </td>
        </tr>
        @endif
        @endforeach
    </table>
</div>
@endsection
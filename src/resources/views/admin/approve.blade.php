@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance_detail.css')}}">
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
        <h2>勤怠詳細</h2>
    </div>
        <form class="content-form" action="{{url('/stamp_correction_request/approve/'.$attendanceCorrectRequest->id)}}" method="post">
        @method('patch')
        @csrf
        <table class="table">
            <tr class="table-row">
                <th class="table-row__header">名前</th>
                <td class="table-row__data">{{$attendanceCorrectRequest->user->name}}</td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">日付</th>
                <td class="table-row__data">
                    <div>{{$attendanceCorrectRequest->date->isoFormat('YYYY年')}}</div>
                    <div>{{$attendanceCorrectRequest->date->isoFormat('M月D日')}}</div>
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">出勤・退勤</th>
                <td class="table-row__data">
                    <div>{{$attendanceCorrectRequest['start_work_time']->format('H:i')}}</div>
                    <span>〜</span>
                    <div>{{$attendanceCorrectRequest['finish_work_time']->format('H:i')}}</div>
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">休憩</th>
                <td class="table-row__data">
                    <div></div>
                    <span>〜</span>
                    <div></div>
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">休憩</th>
                <td class="table-row__data">
                    <div></div>
                    <span>〜</span>
                    <div></div>
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">休憩</th>
                <td class="table-row__data">
                </td>
            </tr>
            <tr class="table-row">
                <th class="table-row__header">備考</th>
                <td class="table-row__data">
                    <div>{{$attendanceCorrectRequest->remarks}}</div>
                </td>
            </tr>
        </table>
        <div class="content-form__button">
            <button class="content-form__button--submit">承認</button>
            <p>承認済み</p>
        </div>
    </form>
</div>
@endsection
@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/request_list.css')}}">
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
        <h2>申請一覧</h2>
    </div>
    <div class="content__link">
        <a href="{{ url('/stamp_correction_request/list', ['status' => 'false'])}}">承認待ち</a>
        <a href="{{ url('/stamp_correction_request/list', ['status' => 'true'])}}">承認済み</a>
    </div>
    <table class="table">
        <tr class="table-row__header">
            <th class="table-row__header--label">状態</th>
            <th class="table-row__header--label">名前</th>
            <th class="table-row__header--label">対象日時</th>
            <th class="table-row__header--label">申請理由</th>
            <th class="table-row__header--label">申請日時</th>
            <th class="table-row__header--label">詳細</th>
        <tr>
        @foreach($attendanceCorrectRequests as $attendanceCorrectRequest)
        @if($attendanceCorrectRequest->approval == false)
        <tr class="table-row__data">
            <td class="table-row__data--approve">承認待ち</td>
            <td class="table-row__data--start_work_time">{{$attendanceCorrectRequest->user->name}}</td>
            <td class="table-row__data--finish_work_time">{{$attendanceCorrectRequest->date->isoFormat('Y/MM/DD')}}</td>
            <td class="table-row__data--break_time">{{$attendanceCorrectRequest->remarks}}</td>
            <td class="table-row__data--total_time">{{$attendanceCorrectRequest->created_at->isoFormat('Y/MM/DD')}}</td>
            <td class="table-row__data--detail">
                <form action="{{url('/stamp_correction_request/approve/'. $attendanceCorrectRequest->id)}}" method="get">
                @csrf
                    <button class="table-row__button--submit" type="submit">詳細</button>
                </form>
            </td>
        </tr>
        @elseif($attendanceCorrectRequest->approval == true)
        <tr class="table-row__data">
            <td class="table-row__data--approve">承認済み</td>
            <td class="table-row__data--start_work_time">{{$attendanceCorrectRequest->user->name}}</td>
            <td class="table-row__data--finish_work_time">{{$attendanceCorrectRequest->date->isoFormat('Y/MM/DD')}}</td>
            <td class="table-row__data--break_time">{{$attendanceCorrectRequest->remarks}}</td>
            <td class="table-row__data--total_time">{{$attendanceCorrectRequest->created_at->isoFormat('Y/MM/DD')}}</td>
            <td class="table-row__data--detail">
                <form action="{{url('/stamp_correction_request/approve/'. $attendanceCorrectRequest->user_attendance_id)}}" method="get">
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
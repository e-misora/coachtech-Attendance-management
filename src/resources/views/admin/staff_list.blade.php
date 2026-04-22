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
        <h2>スタッフ一覧</h2>
    </div>
    <div class="pagination">

    </div>
    <table class="table">
        <tr class="table-row__header">
            <th class="table-row__header--label">名前</th>
            <th class="table-row__header--label">メールアドレス</th>
            <th class="table-row__header--label">月次勤怠</th>
        <tr>
        @foreach($users as $user)
        <tr class="table-row__data">
            <td class="table-row__data--date">{{$user->name}}</td>
            <td class="table-row__data--start_work_time">{{$user->email}}</td>
            <td class="table-row__data--detail">
                <form action="{{url('/admin/attendance/staff',$user->userAttendance->pluck('id')->implode(','))}}" method="get">
                @csrf
                    @php
                        $attendanceIds = $user->userAttendance->pluck('id')->toArray();
                    @endphp
                    @foreach($attendanceIds as $id)
                        <input type="hidden" name="id[]" value="{{ $id }}">
                    @endforeach
                    <button class="table-row__button--submit" type="submit">詳細</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
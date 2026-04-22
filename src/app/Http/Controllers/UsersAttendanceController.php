<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\UserAttendance;
use App\Models\BreakTime;
use App\Models\ButtonLog;
use App\Models\AttendanceCorrectRequest;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Auth;

class UsersAttendanceController extends Controller
{
    public function create(){
        Carbon::setLocale('ja');
        $date = Carbon::now()->isoFormat('YYYY年M月D日(ddd)');
        $time = Carbon::now()->format('H:i');
        $userAttendance = UserAttendance::all();
        return view('attendance',compact('date','time','userAttendance'));
    }

    public function startWork(Request $request){
        $userId = Auth::id();
        $today = Carbon::today();
        $alreadyPressed = ButtonLog::where('user_id', $userId)
            ->where('last_pressed_date', $today)
            ->exists();
        if ($alreadyPressed) {
            return back();
        }
        ButtonLog::create([
            'user_id'=>$userId,
            'last_pressed_date'=>$today,
        ]);
        Carbon::setLocale('ja');
        $date = Carbon::now();
        $startWorkTime = Carbon::now()->format('H:i');
        UserAttendance::create([
            'user_id'=>$userId,
            'date'=>$date,
            'start_work_time'=>$startWorkTime,
        ]);
        return redirect('/attendance/at_work');
    }

    public function atWork(){
        Carbon::setLocale('ja');
        $date = Carbon::now()->isoFormat('YYYY年MM月DD日(ddd)');
        $time = Carbon::now()->format('H:i');
        return view('at_work',compact('date','time'));
    }

    public function update(Request $request){
        if ($request->has('finish_work_time')) {
            $finishWorkTime = Carbon::now()->format('H:i');
            $userAttendance = UserAttendance::latest()->first();
            $userAttendance->update([
                'finish_work_time' => $finishWorkTime,
            ]);
            return redirect('/attendance/finish_work');
        } elseif ($request->has('start_break_time')) {
            $userAttendance = UserAttendance::latest()->first();
            $startBreakTime = Carbon::now()->format('H:i');
            $breakTime::create([
                'user_attendance_id'=>$userAttendance->id,
                'start_break_time'=>$startBreakTime,
            ]);
            return redirect('/attendance/break_time');
        } else {
            $message = 'ボタンは押されませんでした';
        }
    }

    public function breakTime(){
        Carbon::setLocale('ja');
        $date = Carbon::now()->isoFormat('YYYY年MM月DD日(ddd)');
        $time = Carbon::now()->format('H:i');
        return view('break_time',compact('date','time'));
    }

    public function finishBreak(Request $request){
        if ($request->has('finish_break_time')) {
            $finishBreakTime = Carbon::now()->format('H:i');
            $breakTime = BreakTime::latest()->first();
            $breakTime->update([
                'finish_break_time' => $finishBreakTime,
            ]);
            return redirect('/attendance/at_work');
        }
    }

    public function finishWork(){
        Carbon::setLocale('ja');
        $date = Carbon::now()->isoFormat('YYYY年MM月DD日(ddd)');
        $time = Carbon::now()->format('H:i');
        return view('finish_work',compact('date','time'));
    }

    public function index(){
        $userId = Auth::id();
        $targetMonth = Carbon::now();
        $startOfMonth = Carbon::parse($targetMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($targetMonth)->endOfMonth();
        $datePeriod = CarbonPeriod::create($startOfMonth, $endOfMonth);
        $userAttendances = UserAttendance::with('breakTime')->where('user_id', $userId)->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->get()
        ->keyBy(function($item) {
        return $item->date->format('Y-m-d');
        });
        $month = Carbon::create('this month');
        $prevMonth = $month->copy()->subMonth();
        $nextMonth = $month->copy()->addMonth();
        return view('attendance_list',compact('userAttendances','datePeriod','month','prevMonth','nextMonth'));
    }

    public function edit($id){
        $name = Auth::user()->name;
        $userAttendance = UserAttendance::find($id);
        $breakTimes = BreakTime::where('user_attendance_id',$id)->get();
        return view('attendance_detail',compact('name','userAttendance','breakTimes'));
    }

    public function detail(AttendanceRequest $request,$id){
        $userAttendance = UserAttendance::find($id);
        $userId = Auth::id();
        AttendanceCorrectRequest::create([
            'user_id'=>$userId,
            'user_attendance_id'=>$userAttendance->id,
            'date'=>$userAttendance->date,
            'start_work_time'=>$request->input('start_work_time'),
            'finish_work_time'=>$request->input('finish_work_time'),
            'remarks'=>$request->input('remarks'),
        ]);
        return redirect('/attendance/detail/{id}');
    }

    public function show(){
        $name = Auth::user()->name;
        $userId = Auth::id();
        $attendanceCorrectRequests = AttendanceCorrectRequest::with('user')->where('user_id', $userId)->get();
        return view('request_list',compact('name','attendanceCorrectRequests'));
    }

}

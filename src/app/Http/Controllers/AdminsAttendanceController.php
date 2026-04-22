<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\BreakTime;
use App\Models\AttendanceCorrectRequest;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Auth;

class AdminsAttendanceController extends Controller
{
    public function index(){
        $date = Carbon::create('first day of this month');
        $prevDate = $date->copy()->subDay();
        $nextDate = $date->copy()->addDay();
        $userAttendances = UserAttendance::with('user')->whereDate('date', $date)->get();
        return view('admin.attendance_list',compact('date','userAttendances','prevDate','nextDate'));
    }

    public function detail($id){
        $userAttendance = UserAttendance::with('user')->where('id',$id)->first();
        $breakTimes = BreakTime::where('user_attendance_id',$id)->get();
        return view('admin.attendance_detail',compact('userAttendance','breakTimes'));
    }

    public function update(AttendanceRequest $request,$id){
        $userAttendance = UserAttendance::find($id);
        $userAttendance->update([
            'start_work_time'=>$request->input('start_work_time'),
            'finish_work_time'=>$request->input('finish_work_time'),
            'remarks'=>$request->input('remarks'),
        ]);
        return redirect()->back();
    }

    public function staffList(){
        $users = User::with('userAttendance')->get();
        return view('admin.staff_list',compact('users'));
    }

    public function staffAttendance(Request $request){
        $targetMonth = Carbon::now();
        $startOfMonth = Carbon::parse($targetMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($targetMonth)->endOfMonth();
        $datePeriod = CarbonPeriod::create($startOfMonth, $endOfMonth);
        $userAttendances = UserAttendance::with('breakTime')->whereIn('id',$request->id)->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->get()
        ->keyBy(function($item) {
        return $item->date->format('Y-m-d');
        });
        $month = Carbon::create('this month');
        $prevMonth = $month->copy()->subMonth();
        $nextMonth = $month->copy()->addMonth();
        return view('admin.staff_attendance',compact('userAttendances','month','prevMonth','nextMonth','datePeriod'));
    }

    public function show(Request $request){
        $status = $request->query('approval', 'false');
        $attendanceCorrectRequests = AttendanceCorrectRequest::with('user')->where('approval', $status)->get();
        return view('admin.request_list',compact('attendanceCorrectRequests'));
    }

    public function edit($id){
        $attendanceCorrectRequest = AttendanceCorrectRequest::with('user')->where('id',$id)->first();
        return view('admin.approve',compact('attendanceCorrectRequest'));
    }

    public function approve(Request $request,$id){
        $attendanceCorrectRequest = AttendanceCorrectRequest::find($id);
        $attendanceCorrectRequest->update([
            'approval' => '1',
        ]);
        $userAttendanceId = $attendanceCorrectRequest->user_attendance_id;
        $userAttendance = UserAttendance::where('id',$userAttendanceId)->first();
        $userAttendance->update([
            'start_work_time' => $attendanceCorrectRequest->start_work_time,
            'finish_work_time' => $attendanceCorrectRequest->finish_work_time,
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->back();
    }
}

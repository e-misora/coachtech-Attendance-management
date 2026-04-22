<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserAttendance extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function BreakTime()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function getFormattedTotalWorkTimeAttribute()
    {
        if (!$this->start_work_time || !$this->finish_work_time) {
            return '00:00';
        }

        $start = Carbon::parse($this->start_work_time);
        $end = Carbon::parse($this->finish_work_time);
        $stayMinutes = $start->diffInMinutes($end);

        $breakMinutes = $this->breakTime->reduce(function ($carry, $break) {
            if ($break->start_break_time && $break->finish_break_time) {
                return $carry + Carbon::parse($break->start_break_time)->diffInMinutes(Carbon::parse($break->finish_break_time));
            }
            return $carry;
        }, 0);

        $workMinutes = max(0, $stayMinutes - $breakMinutes);

        $hours = floor($workMinutes / 60);
        $minutes = $workMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }


    protected $fillable = [
        'user_id',
        'date',
        'start_work_time',
        'finish_work_time',
    ];

    protected $casts = [
        'start_work_time' => 'datetime',
        'finish_work_time' => 'datetime',
        'date' => 'datetime',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    public function UserAttendance()
    {
        return $this->belongsTo(UserAttendance::class);
    }

    protected $fillable = [
        'user_attendance_id',
        'start_break_time',
        'finish_break_time',
    ];

    protected $casts = [
        'start_break_time' => 'datetime',
        'finish_break_time' => 'datetime',
    ];

}

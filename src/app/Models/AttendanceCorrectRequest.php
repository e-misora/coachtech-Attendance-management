<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrectRequest extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = [
        'user_id',
        'user_attendance_id',
        'date',
        'start_work_time',
        'finish_work_time',
        'remarks',
        'approval'
    ];

    protected $casts = [
        'start_work_time' => 'datetime',
        'finish_work_time' => 'datetime',
        'date' => 'datetime',
        'approval' => 'boolean',
    ];

}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\UserAttendance;

class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_attendance_id' => UserAttendance::factory(),
            'start_break_time' => function (array $attributes) {
                $parentStart = UserAttendance::find($attributes['user_attendance_id']);
                return $this->faker->dateTimeBetween($parentStart->start_work_time, $parentStart->start_work_time . ' +5 hours')->format('H:i');
            },
            'finish_break_time' => function (array $attributes) {
                return Carbon::parse($attributes['start_break_time'])->addHour()->format('H:i');
            },
        ];
    }
}

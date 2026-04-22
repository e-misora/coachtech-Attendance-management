<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserAttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_work_time = $this->faker->dateTimeBetween('09:00:00', '12:00:00');

        return [
            'user_id' => User::factory(),
            'date' => $this->faker->unique()->dateTimeBetween('-1 month','+1 month')->format('Y/m/d'),
            'start_work_time' => $start_work_time->format('H:i'),
            'finish_work_time' => $this->faker->dateTimeBetween($start_work_time, $start_work_time->modify('+8 hours'))->format('H:i'),
        ];
    }
}

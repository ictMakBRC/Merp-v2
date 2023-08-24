<?php

namespace Database\Factories\HumanResource\Settings;

use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HumanResource\Settings\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Department::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'type' => $this->faker->randomElement(["Full Time", "Part Time", "department", "unit", "sub-unit", "laboratory"]),
            'description' => $this->faker->realText(),
            'prefix' => 'DPT',
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

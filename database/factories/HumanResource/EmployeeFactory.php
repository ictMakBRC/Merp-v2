<?php

namespace Database\Factories\HumanResource;

use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return false;
        return [
            'entry_type' => $this->faker->randomElement(['official', 'project', 'volunteer', 'intern', 'trainee']),
            'employee_number' => $this->faker->unique()->randomNumber(6),
            'nin_number' => 'cm9' . $this->faker->unique()->randomNumber(6),
            'title' => $this->faker->randomElement(['mr', 'mrs', 'miss', 'dr', 'prof','engr']),
            'surname' =>  $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'nationality' => 'Ugandan',
            'birth_date' => $this->faker->dateTimeBetween('-35 years', '-18 years'),
            'birth_place' => 'kampala',
            'religious_affiliation' => $this->faker->randomElement(['anglican', 'catholic', 'moslem']),
            'email' => $this->faker->safeEmail(),
            'alt_email' => $this->faker->safeEmail(),
            'contact' => $this->faker->phoneNumber(),
            'alt_contact' => $this->faker->phoneNumber(),
            'work_type' => $this->faker->randomElement(["full time", "part time", "volunteer", "intern", "trainee", "probation", "commission"]),
            'join_date' =>  $this->faker->dateTimeBetween('-10 month', 'now'),
            'tin_number' => $this->faker->unique()->randomNumber(6),
            'nssf_number' => $this->faker->unique()->randomNumber(6),
            'is_active' => true,
        ];
    }
}

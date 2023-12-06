<?php

namespace Database\Factories;

use App\Models\HumanResource\GrievanceType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrievanceType>
 */
class GrievanceTypeFactory extends Factory
{
    /**
    * @var string
    */
    protected $model = GrievanceType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return false;
        return [
            'name' => $name = $this->faker->unique()->words(3, true),
            'slug' => Str::slug($name),
             'description' => $this->faker->realText(),
        ];
    }
}

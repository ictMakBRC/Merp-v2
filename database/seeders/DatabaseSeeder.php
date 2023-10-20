<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\GrievanceType;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\Settings\Station;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    const IMAGE_URL = 'https://source.unsplash.com/random/200x200/?img=1';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (env('LARATRUST_SEED', false)) {
            $this->call(LaratrustSeeder::class);

        }
        $this->withProgressBar(20, fn () => Employee::factory()->count(20)
            ->sequence(
                fn ($sequence) => ['designation_id' => Designation::factory(), 'station_id' => Station::factory(), 'department_id' => Department::factory()]
            )
            ->has(User::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Employees created.');

        if (env('SEED_USERS', false)) {
            $this->call(UserSeeder::class);
        }

        //Grievance types
        GrievanceType::factory()->count(50)->create();
    }

    /**
     * Status bar to show us the seeder completion status after running the seeder command
     */
    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}

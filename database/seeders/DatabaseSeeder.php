<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\HumanResource\GrievanceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (env('LARATRUST_SEED', false)) {
            $this->call(LaratrustSeeder::class);
        }


        if (env('SEED_USERS', false)) {
            $this->call(UserSeeder::class);
        }

        //Grievance types
        GrievanceType::factory()->count(50)->create();
    }
}

<?php

namespace Tests\Feature\HumanResource\Grievances;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Str;
use App\Models\HumanResource\GrievanceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Livewire\HumanResource\GrievanceTypes\Create;

class GrievanceTypesTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_grievance_types_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/human-resource/grievance-types');

        $response->assertStatus(200);
    }

    public function test_grievance_types_data_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $grievanceTypes = GrievanceType::factory()->count(50)->create();

        $response = $this->actingAs($user)->get('/human-resource/grievance-types', ['grievanceTypes' => $grievanceTypes]);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\HumanResource\Grievances;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateGrievanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_grievance_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/human-resource/grievances/create');

        $response->assertStatus(200);
    }
    public function test_grievance_can_be_saved(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/human-resource/grievances', [

        ]);

        $response->assertStatus(200);
    }

}

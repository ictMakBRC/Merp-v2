<?php

namespace Tests\Feature\HumanResource\Grievances;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateGrievanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_grievance_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/human-resource/grievances/create');

        $response->assertStatus(200);
    }

}

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
    public function test_register_grievance_types_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/human-resource/grievance-types/create');

        $response->assertStatus(200);
    }

    public function test_can_store_a_grievance():void
    {
        $this->actingAs(User::factory()->create());

        $name = 'foo bar';
        $slug = Str::slug($name);

        Livewire::test(Create::class)
            ->set('name', $name)
            ->set('slug', $slug)
            ->call('store');

        $grievanceType =  GrievanceType::where('slug', $slug)->exists();

        $this->assertTrue($grievanceType);
    }
    public function test_name_is_required():void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('name', '')
            ->call('store')
            ->assertHasErrors(['name' => 'required']);
    }
    public function test_slug_is_required():void
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('slug', '')
            ->call('store')
            ->assertHasErrors(['slug' => 'required']);
    }

    public function test_user_is_redirected_to_grievances_page_after_a_grievance_is_saved(): void
    {
        $this->actingAs(User::factory()->create());

        $name = 'foo bar';
        $slug = Str::slug($name);

        Livewire::test(Create::class)
            ->set('name', $name)
            ->set('slug', $slug)
            ->call('store')
            ->assertRedirect(route('grievance-types'));
    }

}

<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ApiIntegrationComponent extends Component
{
    use WithPagination;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $token = '';

    public $user_id;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function generateToken(User $user)
    {
        $this->user_id = $user->id;
        $token = $user->createToken($user->fullName)->plainTextToken;
        $this->token = $token;

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Token Generated successfully',
            'text' => 'Please copy and securely send the token to the respective institution for integration with AFRICA PGI-NIMS',
        ]);
    }

    public function revokeToken(User $user)
    {
        $user->tokens()->delete();
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'info',
            'message' => 'TOKEN REVOKED',
            'text' => $user->fullName.' will nolonger access AFRICA PGI-NIMS API',
        ]);
    }

    public function resetValues()
    {
        $this->reset();
    }

    public function filterUsers()
    {
        $users = User::search($this->search)->where('category', 'External-Application')
            ->with('tokens');

        return $users;
    }

    public function render()
    {
        $users = $this->filterUsers()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.user-management.api-integration-component', compact('users'))->layout('layouts.app');
    }
}

<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserListView extends Component
{
    #[Url (as: 'q')]
    public $search = "";
    public $filteredUsers;
    public $roleOptions;

    public $selectedRole = "";
    public $roleName = [];

    public $role;

    public function mount()
    {
        $this->roleOptions = Role::all();
    }

    public function render()
    {

        if ($this->selectedRole){
            $this->filteredUsers = User::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
                ->where('id', '!=', auth()->user()->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', $this->selectedRole);
                })
                ->get();

        }
        else {
            $this->filteredUsers = User::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
                ->where('id', '!=', auth()->user()->id)
                ->get();

        }

        return view('livewire.user-list-view', [
            'users' => $this->filteredUsers,
        ]);
    }

    public function changePermission($userId): void
    {
        $user = User::find($userId);
        $user->roles()->detach();
        $user->assignRole($this->roleName);
    }

}

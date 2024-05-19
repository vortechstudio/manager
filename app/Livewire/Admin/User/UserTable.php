<?php

namespace App\Livewire\Admin\User;

use App\Livewire\OrderTrait;
use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use LivewireAlert, OrderTrait, WithPagination;

    public $users;

    public function mount()
    {
        if (empty($this->users)) {
            $this->users = User::when($this->search, fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage);
        } else {
            $this->users = $this->users->with('user')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.admin.user.user-table');
    }
}

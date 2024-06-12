<?php

namespace App\Livewire\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;
    public bool $action = true;
    public string $type = '';
    //filter
    public string $search = '';
    public string $orderField = 'name';
    public string $orderDirection = 'asc';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function setOrderField(string $name): void
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        $users = match ($this->type) {
            'research' => User::join(config('database.connections.railway.database').'.research_user', 'users.id', config('database.connections.railway.database').'.research_user.user_id')
                ->join('user_socials', 'users.id', 'user_socials.user_id')
                ->join(config('database.connections.railway.database').'.user_railways', 'users.id', config('database.connections.railway.database').'.user_railways.user_id')
                ->paginate($this->perPage),
        };
//        dd($users);
        return view('livewire.user.user-table', [
            'users' => $users,
        ]);
    }
}

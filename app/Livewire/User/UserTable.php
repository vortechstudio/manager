<?php

namespace App\Livewire\User;

use App\Models\User\Railway\UserRailway;
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
            'research' => UserRailway::with('user')
                ->join('research_user', 'user_railways.id', 'research_user.user_railway_id')
                ->paginate($this->perPage),
        };

        //        dd($users);
        return view('livewire.user.user-table', [
            'users' => $users,
        ]);
    }
}

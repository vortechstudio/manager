<?php

namespace App\Livewire\Railway\Finance;

use App\Models\Railway\Config\RailwayBanque;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    public string $name = '';

    public string $description = '';

    public float $interest_min = 0;

    public float $interest_max = 0;

    public float $express_base = 0;

    public float $public_base = 0;

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

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'interest_min' => 'required',
            'interest_max' => 'required',
            'express_base' => 'required',
            'public_base' => 'required',
        ]);

        try {
            $bank = RailwayBanque::create([
                'uuid' => \Str::uuid(),
                'name' => $this->name,
                'description' => $this->description,
                'interest_min' => $this->interest_min,
                'interest_max' => $this->interest_max,
                'express_base' => $this->express_base,
                'public_base' => $this->public_base,
            ]);

            $bank->generate();
            $this->alert('success', 'Banque enregistre avec succes');
            $this->dispatch('closeModal', 'addBank');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $bank = RailwayBanque::find($id);

        try {
            $bank->delete();

            Storage::delete("logos/banks/{$bank->name}.webp");
            $this->alert('success', 'Banque supprimé avec succes');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.railway.finance.finance-table', [
            'banks' => RailwayBanque::with('fluxes')
                ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}

<?php

namespace App\Livewire\Railway\Finance;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Config\RailwayBanque;
use Carbon\Carbon;
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

    public string $blocked_by = '';
    public int $blocked_by_id = 0;

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

    public function save(): void
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
                'blocked_by' => $this->blocked_by,
                'blocked_by_id' => $this->blocked_by_id
            ]);

            $bank->generate();
            $this->alert('success', 'Banque enregistre avec succes');
            $this->dispatch('closeModal', 'addBank');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function destroy(int $id): void
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

    public function export()
    {
        $banks = RailwayBanque::all()->toJson();

        try {
            Storage::put('data/railway_banque.json', $banks);
            $this->alert('success', "Export effectué");
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Une erreur à eu lieu !");
        }
    }

    public function import()
    {
        try {
            $data_banques = json_decode(Storage::get('data/railway_banque.json'), true);

            foreach ($data_banques as $banque) {
                $bq = RailwayBanque::updateOrCreate(['id' => $banque['id']], [
                    'name' => $banque['name'],
                    'uuid' => $banque['uuid'],
                    'id' => $banque['id'],
                    'description' => $banque['description'],
                    'express_base' => $banque['express_base'],
                    'interest_max' => $banque['interest_max'],
                    'interest_min' => $banque['interest_min'],
                    'public_base' => $banque['public_base'],
                ]);

                $bq->generate();
            }

            $this->alert('success', "Import effectuer");
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Une erreur à eu lieu !");
        }
    }

    public function render()
    {
        return view('livewire.railway.finance.finance-table', [
            'banks' => RailwayBanque::with('fluxes')
                ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}

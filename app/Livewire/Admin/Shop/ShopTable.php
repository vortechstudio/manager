<?php

namespace App\Livewire\Admin\Shop;

use App\Models\Config\Shop;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ShopTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $orderField = 'service_id';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    public int $service_id = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'service_id'],
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
        try {
            if (Shop::where('service_id', $this->service_id)->exists()) {
                $this->alert('warning', 'Vous ne pouvez pas ouvrir une boutique déja ouverte !');
            } else {
                Shop::create([
                    'service_id' => $this->service_id,
                ]);
                $this->alert('success', 'Boutique ajouter avec succès');
            }
            $this->dispatch('closeModal', 'addShop');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de l\'ajout de la boutique !');
        }
    }

    public function destroy(int $shop_id): void
    {
        try {
            $shop = Shop::find($shop_id);
            $shop->delete();
            $this->alert('success', 'Boutique supprimé avec succès');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function render()
    {
        return view('livewire.admin.shop.shop-table', [
            'shops' => Shop::orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}

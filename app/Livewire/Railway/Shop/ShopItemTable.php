<?php

namespace App\Livewire\Railway\Shop;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\ShopCategory;
use App\Models\Railway\Core\ShopItem;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShopItemTable extends Component
{
    use LivewireAlert, WithPagination;

    public ShopCategory $category;

    // filter
    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'asc';

    public int $perPage = 10;

    public string $bySection = '';

    public string $byCurrencyType = '';

    public string $byRarity = '';

    public int $item_id;

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

    public function delete(int $item_id)
    {
        $this->item_id = $item_id;
        $item = ShopItem::find($item_id);

        $this->alert('question', "Êtes-vous sur de vouloir surpprimer ce produit: {$item->name} ?", [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Oui',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Non',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function confirmedDelete()
    {
        try {
            $item = ShopItem::find($this->item_id);
            if ($item->is_packager) {
                $this->alert('error', "Impossible de supprimer ce produit car il fait partie d'un package", ['toast' => false]);
            }

            if (\Storage::exists('icons/railway/shop/items/'.\Str::slug($item->name).'.png')) {
                \Storage::delete('icons/railway/shop/items/'.\Str::slug($item->name).'.png');
            } else {
                \Storage::delete('icons/railway/shop/items/'.\Str::slug($item->name).'.gif');
            }
            $item->delete();
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function render()
    {
        return view('livewire.railway.shop.shop-item-table', [
            'items' => ShopItem::where('shop_category_id', $this->category->id)
                ->when($this->search, fn (Builder $query) => $query->where('name', 'like', '%'.$this->search.'%'))
                ->when($this->bySection, fn (Builder $query) => $query->where('section', $this->bySection))
                ->when($this->byCurrencyType, fn (Builder $query) => $query->where('currency_type', $this->byCurrencyType))
                ->when($this->byRarity, fn (Builder $query) => $query->where('rarity', $this->byRarity))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}

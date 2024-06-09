<?php

namespace App\Livewire\Railway\Shop;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\ShopCategory;
use App\Models\Railway\Core\ShopItem;
use App\Models\Railway\Core\ShopPackage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ShopPackageForm extends Component
{
    use LivewireAlert;

    public ShopCategory $category;

    public $products;

    //Form
    public array $selectedProducts = [];

    public string $name = '';

    public string $description = '';

    public string $currency_type = '';

    public int|float $price = 0;

    public function mount()
    {
        $this->products = ShopItem::all();
    }

    public function save()
    {
        try {
            $package = ShopPackage::create([
                'name' => $this->name,
                'description' => $this->description,
                'currency_type' => $this->currency_type,
                'price' => $this->price,
                'shop_category_id' => $this->category->id,
            ]);

            foreach ($this->selectedProducts as $select) {
                $package->items()->attach($select);

                ShopItem::find($select)->update(['is_packager' => true]);
            }

            $this->dispatch('closeModal', 'addPackage');
            $this->alert('success', 'Le package à bien été créer');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function render()
    {
        return view('livewire.railway.shop.shop-package-form');
    }
}

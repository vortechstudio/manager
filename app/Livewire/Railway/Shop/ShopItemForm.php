<?php

namespace App\Livewire\Railway\Shop;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\ShopCategory;
use App\Models\Railway\Core\ShopItem;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShopItemForm extends Component
{
    use LivewireAlert, WithFileUploads;
    public ShopItem $item;
    public ShopCategory $category;

    // form
    public string $name = '';
    public string $section = '';
    public string $description = '';
    public string $currency_type = '';
    public string $rarity = '';
    public string $model = '';
    public ?string $recursive_periodicity = null;
    public ?string $disponibility_end_at = null;
    public ?string $stripe_token = '';
    public float|int $price = 0;
    public bool $blocked = false;
    public bool $recursive = false;
    public bool $is_packager = false;
    public ?int $blocked_max = 0;
    public int $qte = 1;
    public ?int $model_id = 0;
    public $icon;

    public function save()
    {

        try {
            ShopItem::create([
                'name' => $this->name,
                'section' => $this->section,
                'description' => $this->description,
                'currency_type' => $this->currency_type,
                'price' => $this->price,
                'rarity' => $this->rarity,
                'disponibility_end_at' => $this->disponibility_end_at,
                'blocked' => $this->blocked,
                'blocked_max' => $this->blocked_max,
                'qte' => $this->qte,
                'recursive' => $this->recursive,
                'recursive_periodicity' => $this->recursive_periodicity,
                'is_packager' => false,
                'stripe_token' => $this->stripe_token,
                'shop_category_id' => $this->category->id,
                'model_id' => $this->model_id,
                'model' => $this->model,
            ]);
            if(isset($this->icon)) {
                $this->uploadedFile();
            }
            $this->dispatch('closeModal', 'addItem');
            $this->alert('success', "Le produit à bien été ajouté !");
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Une erreur à eu lieu !");
        }
    }

    public function uploadedFile()
    {
        try {
            $this->icon->storeAs(
                path: 'icons/railway/shop/items/',
                name: \Str::slug($this->name).'.'.$this->icon->getClientOriginalExtension(),
            );
        }catch (\Exception $exception){
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Impossible d'ajouter l'image !");
        }
    }

    public function render()
    {
        return view('livewire.railway.shop.shop-item-form');
    }
}

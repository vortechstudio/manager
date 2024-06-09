<?php

namespace App\Livewire\Railway\Shop;

use App\Models\Config\Service;
use App\Models\Config\Shop;
use App\Models\Railway\Core\ShopCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ShopTable extends Component
{
    use LivewireAlert, WithPagination;

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        return view('livewire.railway.shop.shop-table', [
            'shop' => Shop::with('categories')
                ->where('service_id', Service::where('name', 'like', '%Railway Manager%')->first()->id)
                ->first(),
        ]);
    }
}

<?php

namespace Database\Seeders\Test;

use App\Models\Railway\Core\ShopCategory;
use App\Models\Railway\Core\ShopItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        ShopCategory::create([
            'name' => 'Lots Mensuels',
            'shop_id' => 1,
        ]);

        ShopCategory::create([
            'name' => 'Spécial',
            'shop_id' => 1,
        ]);

        ShopCategory::create([
            'name' => 'Bonus',
            'shop_id' => 1,
        ]);

        ShopCategory::create([
            'name' => 'TPoint',
            'shop_id' => 1,
        ]);

        // Produit
        ShopItem::create([
            'name' => 'SNCF 141P',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'tpoint',
            'price' => 420,
            'disponibility_end_at' => Carbon::now()->addDays(30),
            'blocked' => true,
            'blocked_max' => 1,
            'shop_category_id' => 1,
        ]);
    }
}

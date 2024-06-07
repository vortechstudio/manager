<?php

namespace Database\Seeders\staging;

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
            'shop_category_id' => 2,
            'rarity' => 'or',
            'section' => 'engine',
            'qte' => 1,
        ]);

        ShopItem::create([
            'name' => '140 Tpoint',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'reel',
            'price' => 3.00,
            'disponibility_end_at' => null,
            'blocked' => false,
            'blocked_max' => null,
            'shop_category_id' => 4,
            'rarity' => 'legendary',
            'section' => 'tpoint',
            'qte' => 140,
            'stripe_token' => 'price_1O471HCJTg16gfTH9rX9720U',
        ]);

        ShopItem::create([
            'name' => '160 Tpoint',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'reel',
            'price' => 3.50,
            'disponibility_end_at' => null,
            'blocked' => false,
            'blocked_max' => null,
            'shop_category_id' => 4,
            'rarity' => 'legendary',
            'section' => 'tpoint',
            'qte' => 160,
            'stripe_token' => 'price_1O472kCJTg16gfTHxWKgSmwL',
        ]);

        ShopItem::create([
            'name' => '300 Tpoint',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'reel',
            'price' => 4.99,
            'disponibility_end_at' => null,
            'blocked' => false,
            'blocked_max' => null,
            'shop_category_id' => 4,
            'rarity' => 'legendary',
            'section' => 'tpoint',
            'qte' => 300,
            'stripe_token' => 'price_1O473lCJTg16gfTHXvkptOZ6',
        ]);

        ShopItem::create([
            'name' => '1 600 Tpoint',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'reel',
            'price' => 19.90,
            'disponibility_end_at' => null,
            'blocked' => false,
            'blocked_max' => null,
            'shop_category_id' => 4,
            'rarity' => 'legendary',
            'section' => 'tpoint',
            'qte' => 1600,
            'stripe_token' => 'price_1O475ACJTg16gfTH3zIh4hyi',
        ]);

        ShopItem::create([
            'name' => '10 simulation',
            'description' => 'Lorem Ipsum',
            'currency_type' => 'argent',
            'price' => 10000,
            'disponibility_end_at' => Carbon::now()->addDays(rand(15, 98)),
            'blocked' => true,
            'blocked_max' => 5,
            'shop_category_id' => 3,
            'rarity' => 'bronze',
            'section' => 'simulation',
            'qte' => 10,
            'stripe_token' => null,
        ]);
    }
}

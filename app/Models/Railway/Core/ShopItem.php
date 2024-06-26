<?php

namespace App\Models\Railway\Core;

use App\Enums\Config\Shop\ShopItemCurrencyTypeEnum;
use App\Enums\Config\Shop\ShopItemRarityEnum;
use App\Enums\Config\Shop\ShopItemRecursivityEnum;
use App\Enums\Config\Shop\ShopItemSectionEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vortechstudio\Helpers\Facades\Helpers;

class ShopItem extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'disponibility_end_at' => 'datetime',
        'section' => ShopItemSectionEnum::class,
        'currency_type' => ShopItemCurrencyTypeEnum::class,
        'rarity' => ShopItemRarityEnum::class,
        'recursive_periodicity' => ShopItemRecursivityEnum::class,
    ];

    protected $appends = [
        'rarity_bg_color',
        'rarity_border_color',
        'image',
        'price_format',
        'has_checkout',
    ];

    public function shopCategory(): BelongsTo
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id');
    }

    public function packages()
    {
        return $this->belongsToMany(ShopPackage::class, 'package_item');
    }

    public function model()
    {
        return $this->morphTo('model', null, 'model_id', 'id');
    }

    public function getImage()
    {
        if (\Storage::exists('icons/railway/shop/items/'.\Str::slug($this->name).'.png')) {
            return \Storage::url('icons/railway/shop/items/'.\Str::slug($this->name).'.png');
        } else {
            return \Storage::url('icons/railway/shop/items/'.\Str::slug($this->name).'.gif');
        }
    }

    public function getHasCheckoutAttribute()
    {
        $user = \Auth::user();
        // Vérification des montants
        $amount_ok = match ($this->currency_type->value) {
            'argent' => $user->railway->argent >= $this->price,
            'tpoint' => $user->railway->tpoint >= $this->price,
            'reel' => true
        };

        if ($amount_ok) {
            return true;
        } else {
            return false;
        }
    }

    public function getImageAttribute()
    {
        return $this->getImage();
    }

    public function getRarityBgColorAttribute()
    {
        return match ($this->rarity->value) {
            'base' => 'bg-gray-200',
            'bronze' => 'bg-brown-200',
            'argent' => 'bg-gray-400',
            'or' => 'bg-yellow-400',
            'legendary' => 'bg-orange-600'
        };
    }

    public function getRarityBorderColorAttribute()
    {
        return match ($this->rarity->value) {
            'base' => 'border-gray-400',
            'bronze' => 'border-brown-400',
            'argent' => 'border-gray-600',
            'or' => 'border-yellow-600',
            'legendary' => 'border-orange-800'
        };
    }

    public function getPriceFormatAttribute()
    {
        return match ($this->currency_type->value) {
            'argent' => '<img src="'.\Storage::url('icons/railway/argent.png').'" alt="" class="w-30px me-2" />'.number_format($this->price, 0, ',', ' '),
            'tpoint' => '<img src="'.\Storage::url('icons/railway/tpoint.png').'" alt="" class="w-30px me-2" />'.number_format($this->price, 0, ',', ' '),
            'reel' => Helpers::eur($this->price)
        };
    }
}

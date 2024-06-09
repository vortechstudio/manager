<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative min-w-250px me-3">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
                </div>
                <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-3" id="perPage">
                    @foreach([10,25,50,100] as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
                <select wire:model.live="bySection" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-auto me-3" id="bySection">
                    <option value="">-- Selectionner la section ---</option>
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemSectionEnum::class)->toArray() as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
                <select wire:model.live="byCurrencyType" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-auto me-5" id="byCurrencyType">
                    <option value="">-- Selectionner le type de monnaie ---</option>
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemCurrencyTypeEnum::class)->toArray() as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
                <select wire:model.live="byRarity" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-auto me-5" id="byRarity">
                    <option value="">-- Selectionner la rareté ---</option>
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemRarityEnum::class)->toArray() as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-toolbar gap-5">
                <button data-bs-toggle="modal" data-bs-target="#addItem" type="button" class="btn btn-sm btn-light">
                    Nouveau Produit
                </button>
                <button data-bs-toggle="modal" data-bs-target="#addPackage" type="button" class="btn btn-sm btn-light">
                    Nouveau Package
                </button>
                <button wire:click="export" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="export"><i class="fa-solid fa-file-upload me-3"></i> Exporter</span>
                    <span wire:loading wire:target="export"><i class="fa-solid fa-spinner fa-spin me-3"></i> Export en cours...</span>
                </button>
                <button wire:click="import" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="import"><i class="fa-solid fa-file-download me-3"></i> Importer</span>
                    <span wire:loading wire:target="import"><i class="fa-solid fa-spinner fa-spin me-3"></i> Export en cours...</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-10">
                <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                        <thead>
                        <tr class="fw-bold fs-3">
                            <th></th>
                            <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="sector" :field="$orderField">Secteur</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="rarity" :field="$orderField">Rareté</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="price" :field="$orderField">Tarif</x-base.table-header>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($items) == 0)
                            <tr>
                                <td colspan="6">
                                    <x-base.is-null text="Aucun articles pour cette catégorie" />
                                </td>
                            </tr>
                        @else
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="symbol symbol-50px">
                                            <img src="{{ $item->image }}" alt="">
                                        </div>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->section->value }}</td>
                                    <td>
                                        <div class="symbol symbol-circle symbol-30px">
                                            <div class="symbol-label {{ $item->rarity_bg_color }}">&nbsp;</div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->price, 2, ',', ' ') }} {{ $item->currency_type->value }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('railway.shop.showProduct', [$category->id, $item->id]) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le produit">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a wire:click="delete({{ $item->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le produit">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
            <div class="mb-10">
                <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                        <thead>
                        <tr class="fw-bold fs-3">
                            <th></th>
                            <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="price" :field="$orderField">Tarif</x-base.table-header>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($category->packages) == 0)
                            <tr>
                                <td colspan="6">
                                    <x-base.is-null text="Aucun articles pour cette catégorie" />
                                </td>
                            </tr>
                        @else
                            @foreach($category->packages()->paginate($perPage) as $item)
                                <tr>
                                    <td>
                                        <div class="symbol-group symbol-hover">
                                            @foreach($item->items as $product)
                                                <div class="symbol symbol-circle symbol-50px">
                                                    <img src="{{ $product->image }}" class="img-fluid" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ number_format($item->price, 2, ',', ' ') }} {{ $item->currency_type->value }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('railway.shop.showProduct', [$category->id, $item->id]) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le produit">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a wire:click="delete({{ $item->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le produit">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $category->packages()->paginate($perPage)->links() }}
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
    @livewire("railway.shop.shop-item-form", ["category" => $category])
    @livewire("railway.shop.shop-package-form", ["category" => $category])
</div>

<x-script.pluginForm />

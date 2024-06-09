<div wire:ignore.self class="modal fade" tabindex="-1" id="addItem">
    <form action="" wire:submit="{{ $item ? 'editing' : 'save' }}" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ $item ? $item->name : 'Nouveau Produit' }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-5">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <div class="mb-10">
                                        <label for="rarity" class="form-label required">Rareté</label>
                                        <select wire:ignore wire:model="rarity" name="rarity" id="rarity" class="form-select" data-placeholder="---  Selectionner une rareté ---" required>
                                            <option></option>
                                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemRarityEnum::class)->toArray() as $item)
                                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <div class="mb-10">
                                        <label for="section" class="form-label required">Section</label>
                                        <select wire:ignore wire:model="section" name="section" id="section" class="form-select" data-placeholder="---  Selectionner une Section ---" required>
                                            <option></option>
                                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemSectionEnum::class)->toArray() as $item)
                                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <x-form.input
                                name="name"
                                label="Nom du produit"
                                required="true" />

                            <x-form.textarea
                                name="description"
                                label="Description"
                                required="true" />

                            <div class="row">
                                <div class="col-sm-12 col-lg-4 mb-5">
                                    <div class="mb-10">
                                        <label for="currency_type" class="form-label required">Monnaie</label>
                                        <select wire:model="currency_type" name="currency_type" id="currency_type" class="form-select" data-placeholder="---  Selectionner un type de matériel ---" required>
                                            <option></option>
                                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemCurrencyTypeEnum::class)->toArray() as $item)
                                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mb-5">
                                    <x-form.input
                                        name="price"
                                        label="Montant" />
                                </div>
                                <div class="col-sm-12 col-lg-4 mb-5">
                                    <x-form.input
                                        name="qte"
                                        label="Quantité" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 mb-5">
                            <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                <input class="form-check-input" wire:click="$toggle('blocked')" wire:model="blocked" name="blocked" id="blocked" type="checkbox" value="true" />
                                <label class="form-check-label" for="blocked">
                                    Bloquer le nombre d'achat
                                </label>
                            </div>
                            @if($blocked)
                                <x-form.input
                                    name="blocked_max"
                                    label="Nombre d'achat possible"/>
                            @endif
                            <x-form.input
                                type="date"
                                name="disponibility_end_at"
                                label="Fin de disponibilité"
                                hint="Supprimer de la boutique à la fin de la date" />

                            <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                <input class="form-check-input" wire:click="$toggle('recursive')" wire:model="recursive" name="recursive" id="recursive" type="checkbox" value="true" />
                                <label class="form-check-label" for="recursive">
                                    Apparait de manière récursive
                                </label>
                            </div>
                            @if($recursive)
                                <div class="mb-10">
                                    <label for="recursive_periodicity" class="form-label">Période de récursivité</label>
                                    <select wire:model="recursive_periodicity" name="recursive_periodicity" id="recursive_periodicity" class="form-select">
                                        <option>---  Selectionner une récursivité ---</option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemRecursivityEnum::class)->toArray() as $item)
                                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="mb-10">
                                <label for="model" class="form-label">Modèle</label>
                                <select wire:model="model" name="model" id="model" class="form-select">
                                    <option>-- Selectionner un modèle --</option>
                                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\ModelTypes::class)->toArray() as $item)
                                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-form.input
                                type="number"
                                name="model_id"
                                label="Identifiant du modèle" />

                            <x-form.input
                                name="stripe_token"
                                label="ID Stripe" />

                            <x-form.image-input
                                name="icon"
                                accept=".png, .gif"
                                width="w-50px h-50px" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush


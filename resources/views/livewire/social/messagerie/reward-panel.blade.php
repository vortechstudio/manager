<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Récompenses</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addReward">
                    Action
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center p-5 mb-5">
                <div class="d-flex">
                    <div class="position-relative w-250px me-3">
                        <i class="fa-solid fa-search fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"></i>
                        <input
                            type="text"
                            class="form-control border-gray-200 h-40px bg-body ps-13 fs-7"
                            wire:model.live.debounce.500ms="search"
                            placeholder="Rechercher une récompense..."
                            data-kt-search-element="input">
                    </div>
                    <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
                        @foreach([4,8,12,16,20,24,28,32,100] as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex flex-row justify-content-start p-5" wire:loading.class="overlay overlay-block">
                <div class="overlay-wrapper w-100" wire:loading.remove>
                    <div class="row">
                        @foreach($rewards as $reward)
                        <div class="col-sm-6 col-lg-3 mb-5">
                            <div class="d-flex flex-row justify-content-between align-items-center bg-gray-100 bg-hover-light-secondary rounded-2 p-5">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <img src="{{ Storage::url('icons/railway/'.$reward->reward_type->value.'.png') }}" alt="">
                                    </div>
                                    <span class="fw-bolder fs-2x">{{ number_format($reward->reward_value, 0, ',', ' ') }}</span>
                                </div>
                                <button wire:click="delete({{ $reward->id }})" class="btn btn-icon btn-outline btn-outline-danger"><i class="fa-solid fa-trash "></i> </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="overlay-layer card-rounded bg-dark bg-opacity-5" wire:loading>
                    <div class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <span>Chargement...</span>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addReward">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Ajout de récompense</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body" x-data="{selectRewardType: ''}">
                        <div class="mb-10">
                            <label for="reward_type" class="form-label required">Type de récompense</label>
                            <select wire:model="reward_type" x-model="selectRewardType" name="reward_type" id="reward_type" class="form-select" required>
                                <option></option>
                                @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\MessageRewardTypeEnum::class)->toArray() as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="reward_value"
                            label="Quantité de la récompense"
                            hint="Si le type correspond à un modèle sa valeur ne peut exceder 1"
                            required="true" />
                        <div x-show="selectRewardType === 'engine'">
                            <x-form.input
                                name="reward_item_id"
                                label="Identifiant du modèle choisie" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-solid fa-plus me-3"></i> Ajouter</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
   <x-base.close-modal />
@endpush

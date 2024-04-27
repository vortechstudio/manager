<div class="d-flex flex-row justify-content-end mb-10 p-5 gap-5">
    <a wire:click="refresh" class="btn btn-sm btn-outline btn-outline-primary" wire:confirm="Cette action va supprimer tous les portes cartes afin de les remplacer, voulez-vous vraiment rafraichir les données ?">
        <span wire:loading.remove wire:target="refresh"><i class="fa-solid fa-refresh me-3"></i> Rafraichir les porte carte</span>
        <span wire:loading wire:target="refresh"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
    </a>
    <button class="btn btn-sm btn-outline btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addCard">
        <i class="fa-solid fa-plus-circle me-2"></i> Ajouter une carte
    </button>

    <div wire:ignore.self class="modal fade" tabindex="-1" id="addCard">
        <form wire:submit="save" method="post" x-data="{type: ''}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau porte carte</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="mb-10">
                                    <label for="class" class="form-label required">Porte carte</label>
                                    <select name="class" id="class" class="form-select" wire:model.live.debounce="class" data-control="select2" data-placeholder="---  Selectionner une classe ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Config\AdvantageCardClassEnum::class)->toArray() as $class)
                                            <option value="{{ $class['value'] }}">{{ $class['label'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="mb-10">
                                    <label for="type" class="form-label required">Type de carte</label>
                                    <select name="type" id="type" class="form-select" x-model="type" wire:model.live.debounce="type" data-placeholder="---  Selectionner un type de carte ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Config\AdvantageCardTypeEnum::class)->toArray() as $type)
                                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="qte"
                                    label="Montant/Qte"
                                    required="true" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="tpoint"
                                    label="Cout pour le joueur"
                                    required="true" />
                            </div>
                        </div>
                        <div class="mb-10" x-show="type === 'engine'">
                            <label for="model_id" class="form-label required">Matériel Roulant</label>
                            <select name="model_id" id="model_id" class="form-select" wire:model.live.debounce="model_id" data-control="select2" data-placeholder="---  Modèle du matériel roulant ---" required>
                                <option></option>
                                @foreach(\Spatie\LaravelOptions\Options::forModels(\App\Models\Railway\Engine\RailwayEngine::where('in_game', true)->get(), 'name', 'id')->toArray() as $engine)
                                    <option value="{{ $engine['value'] }}">{{ $engine['label'] }}</option>
                                @endforeach
                            </select>
                            @error('model_id')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-solid fa-check-circle me-3"></i> Enregistrer</span>
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
    <script !src="">
        document.addEventListener('livewire:init', () => {
            document.querySelectorAll("[data-control='select2']").forEach(select => {
                $(select).select2()
            })
        })
    </script>
@endpush

<div class="border border-1 border-primary p-2 rounded-2 mb-5 mx-0">
    <div class="d-flex justify-content-end align-items-center">
        <button class="btn btn-xs btn-icon btn-outline btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modalEdit">
            <span><i class="fa-solid fa-edit"></i> </span>
        </button>
        @if($service->status->value == 'idea')
            <button wire:click="steping('develop')" class="btn btn-xs btn-icon btn-outline btn-outline-info me-2" data-bs-toggle="tooltip" data-bs-title="Passer en développement" wire:confirm="Voulez-vous passer ce service en développement ?" wire:loading.attr="disabled">
                <span wire:target="steping('develop')" wire:loading.remove><i class="fa-solid fa-boxes"></i> </span>
                <span wire:target="steping('develop')" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> </span>
            </button>
        @elseif($service->status->value == 'develop')
            <button wire:click="steping('production')" class="btn btn-xs btn-icon btn-outline btn-outline-success me-2" data-bs-toggle="tooltip" data-bs-title="Passer en production" wire:confirm="Voulez-vous supprimer ce service ?" wire:loading.attr="disabled">
                <span wire:target="steping('production')" wire:loading.remove><i class="fa-solid fa-boxes"></i> </span>
                <span wire:target="steping('production')" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> </span>
            </button>
        @endif
        <button wire:click="destroy" class="btn btn-xs btn-icon btn-outline btn-outline-danger me-2" data-bs-toggle="tooltip" data-bs-title="Supprimer le service" wire:confirm="Voulez-vous supprimer ce service ?" wire:loading.attr="disabled">
            <span wire:target="destroy" wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
            <span wire:target="destroy" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> </span>
        </button>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modalEdit">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edition du service: {{ $service->name }}</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <x-form.input
                                            name="name"
                                            label="Nom du service"
                                            required="true" />
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <x-form.input
                                            name="url"
                                            label="Url du projet" />
                                    </div>
                                </div>
                                <x-form.textarea
                                    name="description"
                                    type="simple"
                                    label="Courte description du service"
                                    required="true" />

                                <x-form.textarea
                                    type="laraberg"
                                    name="page_content"
                                    label="Contenue de la page de présentation du service" />
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="mb-10">
                                    <label for="type" class="form-label required">Type de service</label>
                                    <select name="type" id="type" wire:model="type" class="form-select" data-control="" data-placeholder="---  Selectionner un type de service ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\ServiceTypeEnum::class)->toArray() as $type)
                                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label for="status" class="form-label required">Type de matériel</label>
                                    <select name="status" id="status" wire:model="status" class="form-select" data-control="" data-placeholder="---  Selectionner un status ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\ServiceStatusEnum::class)->toArray() as $status)
                                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-form.input
                                    name="repository"
                                    label="Repo du projet" />
                            </div>
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


@push('script')
    <script>
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })

    </script>
    <x-base.close-modal />
@endpush

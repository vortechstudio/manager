<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un service..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addService"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau service</button>
    </div>

    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="type" :field="$orderField">Type</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="status" :field="$orderField">Status</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($services->count() == 0)
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucun service enregistrées" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>
                            <div class="d-flex flex-row align-items-center gap-3">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $service->getImage($service->id, 'default') }}" alt="{{ $service->name }}">
                                </div>
                                @isset($service->latest_version)
                                    <div class="d-flex flex-column">
                                        <span class="fs-2 fw-semibold">{{ $service->name }}</span>
                                        <div class="text-muted">Dernière Version: {{ $service->latest_version->version }}</div>
                                    </div>
                                @else
                                    <span class="fs-2 fw-semibold">{{ $service->name }}</span>
                                @endif
                            </div>
                        </td>
                        <td>{!! $service->type_label !!}</td>
                        <td>{!! $service->status_label !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('social.services.show', $service->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le service"><i class="fa-solid fa-eye"></i></a>
                                <button wire:click="destroy({{ $service->id }})" onclick="confirm('Voulez-vous supprimer ce service ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le service">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $service->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $service->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
        {{ $services->links() }}
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addService">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau Service</h3>

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
                                <x-form.input
                                    name="folder"
                                    label="Dossier du projet" />
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

@push("scripts")
    <x-base.close-modal />
    <script type="text/javascript">
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })
    </script>
@endpush

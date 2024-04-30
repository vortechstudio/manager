<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une configuration..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addConfig"><i class="fa-solid fa-plus-circle me-3"></i> Nouvelle configuration</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="value" :field="$orderField">Désignation</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($configs->count() == 0)
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucune configuration enregistrées" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($configs as $config)
                    <tr>
                        <td>{{ $config->name }}</td>
                        <td>{{ $config->value }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button wire:click="destroy({{ $config->id }})" onclick="confirm('Voulez-vous supprimer cette configuration ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la configuration">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $config->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $config->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $configs->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addConfig">
        <form wire:submit="save" method="post">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle configuration</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Désignation"
                            required="true" />

                        <x-form.input
                            name="value"
                            label="Valeur"
                            required="true" />
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
    @push('scripts')
        <x-base.close-modal />
    @endpush
</div>

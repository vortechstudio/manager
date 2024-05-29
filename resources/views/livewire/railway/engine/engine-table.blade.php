<div>
    <div class="d-flex flex-row align-items-end gap-5 mb-5">
        <div class="position-relative w-250px">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <a href="{{ route('railway.materiels.create') }}" class="btn btn-outline btn-outline-primary"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau Matériel</a>
        <a wire:click="export" class="btn btn-outline btn-outline-secondary "><i class="fa-solid fa-file-upload me-3"></i> Exporter</a>
        <a data-bs-toggle="modal" href="#import" class="btn btn-outline btn-outline-secondary"><i class="fa-solid fa-file-download me-3"></i> Importer</a>
    </div>
    <div class="table-responsive">
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="type_train" :field="$orderField">Type de matériel</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="active" :field="$orderField">Status</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($engines->count() > 0)
                <tbody>
                @foreach($engines as $engine)

                    <tr>
                        <td>{{ $engine->id }}</td>
                        <td>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-30px symbol-2by3 me-5">
                                    <img src="{{ $engine->getFirstImage($engine->id) }}" alt="{{ $engine->name }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ $engine->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $engine->type_train }}</td>
                        <td>
                            <span class="badge badge-light-{{ $engine->active ? 'success' : 'danger' }}">{{ $engine->active ? 'Active' : 'Inactif' }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('railway.materiels.show', $engine) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer le matériel">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('railway.materiels.edit', $engine) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edité le matériel">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <button wire:click="destroy({{ $engine->id }})" onclick="confirm('Voulez-vous supprimer ce matériel ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le matériel">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $engine->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $engine->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucuns Matériels disponible" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $engines->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="import">
        <form action="" wire:submit="import">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Import des fichiers de matériel roulant</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="status" class="form-label required">Déploiement souhaité</label>
                            <select wire:model="status" name="status" id="status" class="form-select" required>
                                <option>-- Selectionner le mode de déploiement --</option>
                                <option value="all">Tous</option>
                                <option value="beta">Canal Béta</option>
                                <option value="production">Canal Production</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Importer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush

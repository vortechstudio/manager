<div>
    <div class="d-flex flex-row align-items-end gap-5 mb-5">
        <div class="position-relative w-250px">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une ligne..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <a href="{{ route('railway.lignes.create') }}" class="btn btn-outline btn-outline-primary"><i class="fa-solid fa-plus-circle me-3"></i> Création d'une ligne</a>
        <button wire:click="export" class="btn btn-outline btn-outline-secondary"><i class="fa-solid fa-file-upload me-3"></i> Exporter</button>
        <button data-bs-toggle="modal" data-bs-target="#import" class="btn btn-outline btn-outline-secondary"><i class="fa-solid fa-file-download me-3"></i> Importer</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Ligne</x-base.table-header>
                <th>Hub d'origine</th>
                <x-base.table-header :direction="$orderDirection" name="price" :field="$orderField">Prix Brut</x-base.table-header>
                <th>Statistiques</th>
                <x-base.table-header :direction="$orderDirection" name="status" :field="$orderField">Status</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($lignes->count() > 0)
                <tbody>
                @foreach($lignes as $ligne)
                    <tr>
                        <td>{{ $ligne->id }}</td>
                        <td>{{ $ligne->name }}</td>
                        <td>{{ $ligne->hub->gare->name }}</td>
                        <td>{{ eur($ligne->price) }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-map-marker me-1"></i>
                                    <span>{{ $ligne->distance }} Km</span>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-clock me-1"></i>
                                    <span>{{ $ligne->time_min }} min</span>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-meta me-1"></i>
                                    <span>{{ $ligne->status }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{!! $ligne->status_label !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('railway.lignes.show', $ligne) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-title="Gérer la ligne">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button @if($ligne->active) wire:click="disabled({{ $ligne->id }})" @else wire:click="enable({{ $ligne->id }})" @endif class="btn btn-icon btn-outline {{ $ligne->active ? 'btn-outline-danger' : 'btn-outline-success' }}" data-bs-toggle="tooltip" data-bs-title="{{ $ligne->active ? 'Désactiver la ligne' : 'Activer la ligne' }}">
                                    <i class="fa-solid {{ $ligne->active ? 'fa-times' : 'fa-check' }}" wire:loading.remove wire:target="{{ $ligne->active ? 'disabled' : 'enabled' }}"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="{{ $ligne->active ? 'disabled' : 'enabled' }}"></i>
                                </button>
                                <button wire:click="destroy({{ $ligne->id }})" onclick="confirm('Voulez-vous supprimer cette ligne ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la ligne">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $ligne->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $ligne->id }})"></i>
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
                            text="Aucunes lignes enregistrées" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $lignes->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="import">
        <form action="" wire:submit="import">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Modal title</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="status" class="form-label required">Déploiement</label>
                            <select wire:model="status" name="status" id="status" class="form-select" required>
                                <option>-- Mode de déploiement --</option>
                                <option value="beta">BETA</option>
                                <option value="production">PRODUCTION</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
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

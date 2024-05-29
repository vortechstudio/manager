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
        <a href="{{ route('railway.hubs.create') }}" class="btn btn-outline btn-outline-primary"><i class="fa-solid fa-plus-circle me-3"></i> Création d'une gare</a>
        <button wire:click="export" class="btn btn-outline btn-outline-secondary"><i class="fa-solid fa-file-upload me-3"></i> Exporter</button>
        <button wire:click="import" class="btn btn-outline btn-outline-secondary"><i class="fa-solid fa-file-download me-3"></i> Importer</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Gare</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="type" :field="$orderField">Type</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="is_hub" :field="$orderField">Hub</x-base.table-header>
                <th>Coordonnées</th>
                <th>Nombre de Ligne</th>
                <th></th>
            </tr>
            </thead>
            @if($gares->count() > 0)
                <tbody>
                @foreach($gares as $gare)
                    <tr>
                        <td>{{ $gare->id }}</td>
                        <td>{{ $gare->name }}</td>
                        <td>{{ $gare->type_gare_string }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="mb-1">{!! $gare->formatIsHub() !!}</span>
                                @if($gare->hub)
                                    {!! $gare->hub->is_active_label !!}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-map-marked me-2"></i>
                                    <span>{{ $gare->latitude }},</span>
                                    <span>{{ $gare->longitude }}</span>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-house me-2"></i>
                                    <span>{{ $gare->city }}</span>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-globe me-2"></i>
                                    <span>{{ $gare->pays }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($gare->is_hub)
                                <span class="badge badge-primary">{{ $gare->hub->lignes()->count() }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('railway.hubs.show', $gare) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer la Gare">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($gare->is_hub)
                                    <button @if($gare->hub->active) wire:click="disabled({{ $gare->id }})" @else wire:click="enabled({{ $gare->id }})" @endif class="btn btn-sm btn-icon {{ $gare->hub->active ? 'btn-outline btn-outline-danger' : 'btn-outline btn-outline-success' }}" data-bs-toggle="tooltip" data-bs-title="{{ $gare->hub->active ? 'Inactiver le système' : 'Activer le système' }}">
                                        <i class="fa-solid {{ $gare->hub->active ? 'fa-times' : 'fa-check' }}" wire:loading.remove wire:target="{{ $gare->hub->active ? 'disabled' : 'enabled' }}"></i>
                                        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="{{ $gare->hub->active ? 'disabled' : 'enabled' }}"></i>
                                    </button>
                                @endif
                                <button wire:click="destroy({{ $gare->id }})" onclick="confirm('Voulez-vous supprimer cette gare ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la gare">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $gare->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $gare->id }})"></i>
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
                            text="Aucunes gares enregistrées" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $gares->links() }}
</div>

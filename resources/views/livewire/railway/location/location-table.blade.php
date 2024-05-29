<div>
    <div class="d-flex flex-row align-items-end gap-5 mb-5">
        <div class="position-relative w-250px">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un service..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <a href="{{ route('railway.location.create') }}" class="btn btn-outline btn-outline-primary"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau service</a>
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
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Nom du service</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="contract_duration" :field="$orderField">Durée des contrats</x-base.table-header>
                <th>Accepté</th>
                <th></th>
            </tr>
            </thead>
            @empty($locations)
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
                @foreach($locations as $location)
                    <tr>
                        <td>
                            <div class="d-flex flex-row align-items-center gap-3">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $location->image }}" alt="{{ $location->name }}">
                                </div>
                                <span class="fs-2 fw-semibold">{{ $location->name }}</span>
                            </div>
                        </td>
                        <td>{{ $location->contract_duration }} {{ Str::plural("Semaine", $location->contract_duration) }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(json_decode($location->type, true) as $type)
                                    <div class="symbol symbol-30px symbol-2by3">
                                        <img src="{{ Storage::url('icons/railway/transport/logo_'.$type.'.svg') }}" alt="" data-bs-toggle="tooltip" data-bs-original-title="{{ Str::ucfirst($type) }}">
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('railway.location.show', $location->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le service de location"><i class="fa-solid fa-eye"></i></a>
                                <button wire:click="destroy({{ $location->id }})" onclick="confirm('Voulez-vous supprimer ce service de location ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le service de location">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $location->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $location->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $locations->links() }}
</div>

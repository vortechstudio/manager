<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <th>Ligne</th>
                <th>Hub d'Origine</th>
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
                        <td>{{ $ligne->status_label }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucunes Lignes enregistrées" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $lignes->links() }}
</div>

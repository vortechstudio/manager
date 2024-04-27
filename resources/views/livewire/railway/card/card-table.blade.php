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
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="description" :field="$orderField">Description</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="class" :field="$orderField">Type/Classe</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="qte" :field="$orderField">Quantité</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="drop_rate" :field="$orderField">Taux de Drop</x-base.table-header>
            </tr>
            </thead>
            @if($cards->count() == 0)
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucun porte carte enregistré" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($cards as $card)
                    <tr>
                        <td>{{ $card->description }}</td>
                        <td>{{ $card->class }} / {{ $card->type }}</td>
                        <td>{{ $card->qte }}</td>
                        <td>{{ $card->drop_rate }} %</td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $cards->links() }}
</div>

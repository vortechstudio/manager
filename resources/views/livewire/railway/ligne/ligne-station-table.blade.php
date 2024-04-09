<div class="row">
    <div class="col-sm-12 col-lg-3 mb-5">
        <div class="card shadow-sm">
            <div class="card-body">
                @if($ligne->stations()->count() == 0)
                    <x-base.is-null text="Aucunes Stations" />
                @else
                    <div class="d-flex flex-column">
                        @foreach($ligne->stations as $station)
                            <div class="d-flex flex-row align-items-center mb-2">
                                @if($ligne->start->name == $station->gare->name || $ligne->end->name == $station->gare->name)
                                    <img src="{{ Storage::url('icons/railway/hub.png') }}" class="w-45px me-3" alt="" />
                                    <span class="fs-1 fw-bold {{ $ligne->start->name == $station->gare->name ? 'text-success' : '' }} {{ $ligne->end->name == $station->gare->name ? 'text-danger' : '' }}">{{ $station->gare->name }}</span>
                                @else
                                    <img src="{{ Storage::url('icons/railway/train-passenger.png') }}" class="w-20px me-3" alt="" />
                                    <span class="fs-3 fw-bold">{{ $station->gare->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-lg-9 mb-5">
        <div class="d-flex flex-row align-items-end mb-5">
            <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <a href="#addStation" data-bs-toggle="modal" class="btn btn-outline btn-outline-primary"><i class="fa-solid fa-plus-circle me-3"></i> Nouvelle station</a>
        </div>
        <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
            <div class="table-loading-message">
                <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
            </div>
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                <thead>
                <tr class="fw-bold fs-3">
                    <x-base.table-header :direction="$orderDirection" name="railway_gare_id" :field="$orderField">Arret</x-base.table-header>
                    <th>Temps</th>
                    <th></th>
                </tr>
                </thead>
                @if($stations->count() > 0)
                    <tbody>
                    @foreach($stations as $station)
                        <tr>
                            <td>{{ $station->gare->name }}</td>
                            <td>{{ $station->time }} min</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button wire:click="destroy({{ $station->id }})" onclick="confirm('Voulez-vous supprimer cette arret ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'arret">
                                        <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $station->id }})"></i>
                                        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $station->id }})"></i>
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
                                text="Aucun arrets enregistrées" />
                        </td>
                    </tr>
                    </tbody>
                @endif
            </table>
        </div>
        {{ $stations->links() }}
    </div>
    <div class="modal fade" tabindex="-1" id="addStation">
        <form wire:submit="save" method="POST">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle Station</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="railway_gare_id" class="form-label required">Type de matériel</label>
                            <select wire:model="railway_gare_id" name="railway_gare_id" id="railway_gare_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner une gare---" required>
                                <option></option>
                                @foreach(\App\Models\Railway\Gare\RailwayGare::all() as $gare)
                                    <option value="{{ $gare->id }}">{{ $gare->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove><i class="fa-solid fa-check me-3"></i> Valider</span>
                            <span wire:loading><i class="fa-solid fa-spinner fa-spin-pulse"></i> Validation en cours...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@push("scripts")
    <script type="text/javascript">
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })
    </script>
@endpush

<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
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
            <div class="card-toolbar gap-3">
                <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBank"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau service</button>
                <button wire:click="export" class="btn btn-outline btn-outline-secondary" wire:loading.attr="disabled" wire:target="export">
                    <span wire:loading.remove wire:target="export"><i class="fa-solid fa-file-export me-2"></i> Exporter</span>
                    <span wire:loading.class.remove="d-none" class="d-none" wire:target="export"><i class="fa-solid fa-file-spinner fa-spin me-2"></i> Export en cours</span>
                </button>
                <button wire:click="import" class="btn btn-outline btn-outline-secondary" wire:loading.attr="disabled" wire:target="export">
                    <span wire:loading.remove wire:target="import"><i class="fa-solid fa-file-import me-2"></i> Importer</span>
                    <span wire:loading.class.remove="d-none" class="d-none" wire:target="import"><i class="fa-solid fa-file-spinner fa-spin me-2"></i> Import en cours</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Nom du service</x-base.table-header>
                        <th>Intêret</th>
                        <th>Emprunts</th>
                        <th></th>
                    </tr>
                    </thead>
                    @if($banks->count() == 0)
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
                        @foreach($banks as $bank)
                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center gap-3">
                                        <div class="symbol symbol-50px symbol-2by3">
                                            <img src="{{ $bank->image }}" alt="{{ $bank->name }}">
                                        </div>
                                        <span class="fs-2 fw-semibold">{{ $bank->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-row mb-2">
                                                <span class="fw-bold">Interet Min</span>
                                                <span>{{ number_format($bank->interest_min, 2, ',', ' ') }} %</span>
                                            </div>
                                            <div class="d-flex flex-row mb-2">
                                                <span class="fw-bold">Interet Max</span>
                                                <span>{{ number_format($bank->interest_max, 2, ',', ' ') }} %</span>
                                            </div>
                                        </div>
                                        <span class="badge badge-info">{{ number_format($bank->latest_flux->interest, 2, ',', ' ') }} %</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-row mb-2">
                                                <span class="fw-bold">Emprunt express</span>
                                                <span>{{ eur($bank->express_base) }}</span>
                                            </div>
                                            <div class="d-flex flex-row mb-2">
                                                <span class="fw-bold">Emprunt marché financier</span>
                                                <span>{{ eur($bank->public_base) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('railway.finance.show', $bank->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le service financier"><i class="fa-solid fa-eye"></i></a>
                                        <button wire:click="destroy({{ $bank->id }})" onclick="confirm('Voulez-vous supprimer ce service financier ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le service financier">
                                            <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $bank->id }})"></i>
                                            <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $bank->id }})"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $banks->links() }}
        </div>
    </div>


    <div wire:ignore.self class="modal fade" tabindex="-1" id="addBank">
        <form wire:submit="save" method="post">
            <div class="modal-dialog modal-lg">
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
                        <x-form.input
                            name="name"
                            label="Nom du service"
                            required="true" />

                        <x-form.textarea
                            type="simple"
                            name="description"
                            label="Description du service" />

                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="mb-10" wire:ignore.self>
                                    <label for="blocked_by" class="form-label">Bloqué par</label>
                                    <select  wire:model="blocked_by" name="blocked_by" id="blocked_by" class="form-select" data-control="select2" data-placeholder="---  Sélectionner un type de blockage ---">
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Config\RailwayBanqueBlockedEnum::class)->toArray() as $item)
                                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <x-form.input
                                    name="blocked_by_id"
                                    label="Identifiant ou valeur de blocage" />
                            </div>
                        </div>


                        <x-base.title
                            title="Interet" />

                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="interest_min"
                                    label="Interet minimal"
                                    required="true"
                                    hint="Valeur décimal accepté" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="interest_max"
                                    label="Interet maximal"
                                    required="true"
                                    hint="Valeur décimal accepté" />
                            </div>
                        </div>


                        <x-base.title
                            title="Emprunt" />

                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="express_base"
                                    label="Emprunt express"
                                    required="true"
                                    hint="Valeur décimal accepté" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="public_base"
                                    label="Emprunt public"
                                    required="true"
                                    hint="Valeur décimal accepté" />
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
    @push('scripts')
        <x-base.close-modal />
    @endpush
</div>
<x-script.pluginForm />

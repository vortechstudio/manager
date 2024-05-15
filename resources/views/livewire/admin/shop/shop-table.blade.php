<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addShop"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau Boutique</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="service_id" :field="$orderField">Service Affilier</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($shops->count() == 0)
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucune boutique enregistrées" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($shops as $shop)
                    <tr>
                        <td>
                            <div class="d-flex flex-row align-items-center gap-3">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $shop->service->getImage($shop->service_id, 'icon') }}" alt="{{ $shop->service->name }}">
                                </div>
                                <span class="fs-2 fw-semibold">Boutique du service: {{ $shop->service->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button wire:click="destroy({{ $shop->id }})" onclick="confirm('Voulez-vous supprimer cette boutique ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la boutique">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $shop->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $shop->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $shops->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addShop">
        <form wire:submit="save" method="post">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle boutique</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="service_id" class="form-label required">Service Affilier</label>
                            <select wire:model="service_id" name="service_id" id="service_id" class="form-select" data-placeholder="---  Selectionner un service ---" required>
                                <option></option>
                                @foreach(\App\Models\Config\Service::all() as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
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

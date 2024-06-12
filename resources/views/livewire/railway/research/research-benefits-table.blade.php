<div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex gap-5">
            <div class="position-relative min-w-250px me-3">
                <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                <input type="text" class="form-control form-control-solid border-gray-200 h-40px ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher..." data-kt-search-element="input">
            </div>
            <select wire:model.live="perPage" class="form-select form-select-solid border-gray-200 h-40px ps-13 fs-7 w-100px me-3" id="perPage">
                @foreach([10,25,50,100] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBenefit">Nouveau bénéfice</button>
        </div>
    </div>
    @if(count($benefits) == 0)
        <x-base.is-null text="Aucun bénéfice actuellement" />
    @else
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
                <tr>
                    <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                    <x-base.table-header :direction="$orderDirection" name="action" :field="$orderField">Action</x-base.table-header>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($benefits as $benefit)
                    <tr>
                        <td>{{ $benefit->name }}</td>
                        <td>{{ $benefit->action }}</td>
                        <td>
                            <button wire:click="delete({{ $benefit->id }})" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Supprimer ce bénéfice" wire:confirm="Valider la suppression" wire:loading.attr="disabled" wire:target="delete({{ $benefit->id }})">
                                <span wire:loading.remove wire:target="delete({{ $benefit->id }})"><i class="fa-solid fa-trash"></i> </span>
                                <span class="d-none" wire:loading.class.remove="d-none" wire:target="delete({{ $benefit->id }})"><i class="fa-solid fa-spinner fa-spin"></i> </span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="modal fade" tabindex="-1" id="addBenefit">
        <form action="" wire:submit="save">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Ajout d'un bénéfice</h3>

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
                            name="action"
                            label="Action déclencheur"
                            required="true" />

                        <x-form.input
                            name="action_count"
                            label="Nombre de l'action"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.class="d-none" wire:target="save">Sauvegarder</span>
                            <span class="d-none" wire:loading.class.remove="d-none" wire:target="save">
                            <div class="spinner-grow me-2" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                            Chargement...
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-script.pluginForm />
@push('scripts')
    <x-base.close-modal />
@endpush

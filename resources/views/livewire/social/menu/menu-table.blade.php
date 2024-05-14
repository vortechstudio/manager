<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un service..." data-kt-search-element="input">
        </div>
        <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMenu"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau Menu</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="section" :field="$orderField">Section</x-base.table-header>
                <th>Titre</th>
                <x-base.table-header :direction="$orderDirection" name="parent_id" :field="$orderField">Parent</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($menus->count() == 0)
                <tbody>
                <tr>
                    <td colspan="3">
                        <x-base.is-null
                            text="Aucun Menu Définie" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($menus as $menu)
                    <tr>
                        <td>{{ $menu->section }}</td>
                        <td>{{ $menu->translations()->first()->title }}</td>
                        <td>{!! $menu->children ? '<i class="fa-solid fa-check text-success"></i>' : '' !!}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $menus->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addMenu">
        <form wire:submit="save" method="post">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau menu</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="sector"
                            label="Section du menu"
                            required="true" />

                        <x-form.input
                            name="titre"
                            label="Titre du menu"
                            required="true" />

                        <x-form.input
                            name="icon"
                            label="Icone du menu" />

                        <div class="mb-10" wire:ignore.self>
                            <label for="parent_id" class="form-label">Parent du menu</label>
                            <select wire:model="parent_id" name="parent_id" id="parent_id" class="form-select" data-placeholder="---  Selectionner un parent ---">
                                <option></option>
                                @foreach(\App\Models\Config\Menu::all() as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->translations()->first()->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input
                            name="url"
                            label="Url symbolique du menu"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-solid fa-check me-3"></i> Valider</span>
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

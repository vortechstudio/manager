<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une quêtes..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <button x-on:click="card_title='Nouvelle quête'; card_new_quest = true; card_quest = true; card_level = false; card_new_level = false" class="btn btn-outline btn-outline-primary me-3"><i class="fa-solid fa-plus-circle me-3"></i> Nouvelle quête</button>
        <button x-show="card_new_quest" x-on:click="card_new_quest = false" class="btn btn-icon btn-outline btn-outline-secondary">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div x-show="card_new_quest">
        <form action="" wire:submit="save" method="POST" x-on:submit="card_new_quest = false">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header bg-inverse">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-light">
                            <Sa></Sa>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <x-form.input
                        name="name"
                        label="Titre de la quête"
                        required="true" />

                    <x-form.textarea
                        type="laraberg"
                        name="description"
                        label="Description de la quête" />

                    <x-form.input
                        name="xp_reward"
                        label="XP Accordée"
                        type="number"
                        required="true" />
                    <div class="row">
                        <div class="col-6">
                            <x-form.input
                                name="action"
                                label="Action Executer"
                                required="true" />
                        </div>
                        <div class="col-6">
                            <x-form.input
                                name="action_count"
                                label="Valeur de l'action"
                                type="number"
                                required="true" />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-end">
                        <button type="submit" class="btn btn-outline btn-outline-primary">
                            <span  wire:loading.remove><i class="fa-solid fa-save me-3"></i> Enregistrer</span>
                            <span wire:loading><i class="fa-solid fa-circle-notch fa-spin ms-3"></i> Veuillez patientez...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Quête</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="xp_reward" :field="$orderField">XP Accordée</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($quests->count() > 0)
                <tbody>
                @foreach($quests as $quest)
                    <tr>
                        <td>{{ $quest->id }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bolder">{{ $quest->name }}</span>
                                <span class="text-muted fs-7 fst-italic">{{ $quest->description }}</span>
                            </div>
                        </td>
                        <td>{{ $quest->xp_reward }} XP</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button wire:click="destroy({{ $quest->id }})" onclick="confirm('Voulez-vous supprimer cette quête ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la quête">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $quest->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $quest->id }})"></i>
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
                            text="Aucunes Quêtes enregistrées" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $quests->links() }}
</div>

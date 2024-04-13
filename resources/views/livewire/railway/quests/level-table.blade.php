<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un niveau..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <button x-on:click="card_title='Réglage des niveaux'; card_new_quest = false; card_quest = false; card_level = true; card_new_level = true" class="btn btn-outline btn-outline-primary me-3"><i class="fa-solid fa-plus-circle me-3"></i> Réglage des niveaux</button>
        <button x-show="card_new_level" x-on:click="card_new_level = false" class="btn btn-icon btn-outline btn-outline-secondary">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="m-5" x-show="card_new_level">
        <form action="" wire:submit="save" method="POST" x-on:submit="card_new_level = false">
            <div class="alert alert-primary d-flex align-items-center p-5">
                <i class="fa-solid fa-exclamation-triangle fs-2hx text-primary me-4"></i>
                <div class="d-flex flex-column">
                    <span class="mb-1 text-dark">Avertissement</span>
                    <span>La réinitialisation des niveaux sera effectuée et supprimera les condition déjà présentes.</span>
                    <span>Effectuer cette manipulation uniquement si vous savez ce que vous faites.</span>
                </div>
            </div>
            <div class="d-flex flex-wrap">
                <button type="submit" class="btn btn-outline btn-outline-primary w-100 me-3"><i class="fa-solid fa-reload me-3"></i> Oui</button>
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
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">Niveau</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="exp_required" :field="$orderField">Limite d'expérience</x-base.table-header>
                <th>Récompense</th>
            </tr>
            </thead>
            @if($levels->count() > 0)
                <tbody>
                @foreach($levels as $level)
                    <tr>
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->exp_required }}</td>
                        <td>
                            <div class="d-flex flew-row align-items-center">
                                <div class="symbol symbol-35px me-5">
                                    <img src="{{ \App\Enums\Railway\Config\LevelRewardTypeEnum::getIcon($level->reward->type) }}" alt="">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ \App\Enums\Railway\Config\LevelRewardTypeEnum::getLabel($level->reward->type) }}</span>
                                    <span><strong>Valeur:</strong> {{ number_format($level->reward->action_count, 0, ',', ' ') }}</span>
                                </div>
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
                            text="Aucun niveau défini" />
                    </td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $levels->links() }}
</div>

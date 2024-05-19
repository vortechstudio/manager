<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Joueurs</h3>
            <div class="card-toolbar">
                <div class="position-relative w-250px me-3">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un joueurs..." data-kt-search-element="input">
                </div>
                <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
                    @foreach([10,25,50,100] as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
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
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Identité du joueurs</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="created_at" :field="$orderField">Date d'obtention</x-base.table-header>
                    </tr>
                    </thead>
                    @empty($users)
                        <tbody>
                        <tr>
                            <td colspan="7">
                                <x-base.is-null
                                    text="Aucun utilisateurs enregistrées" />
                            </td>
                        </tr>
                        </tbody>
                    @else
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center gap-3">
                                        <div class="symbol symbol-50px me-2">
                                            <img src="{{ $user->user->socials()->first()->avatar }}" alt="{{ $user->user->name }}">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fs-2 fw-semibold">{{ $user->user->name }}</span>
                                            <span class="text-muted">UUID: {{ $user->user->railway->uuid }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush

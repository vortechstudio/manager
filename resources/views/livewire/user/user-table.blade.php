<div class="card shadow-sm">
    <div class="card-header">
        <div class="card-title">
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
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <div class="card-body">
        @if(count($users) == 0)
            <x-base.is-null text="Aucun utilisateurs"
        @else
            @if($type == 'research')
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Identifiant</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="in_unlocked" :field="$orderField">Débloquer</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="current_level" :field="$orderField">Niveau Actuel</x-base.table-header>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30px symbol-circle me-3">
                                        <img src="{{ $user->user->socials()->first()->avatar }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span>{{ $user->user->name }}</span>
                                        <span>{{ $user->uuid }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fa-solid {{ $user->is_unlocked ? 'fa-check-circle text-success' : 'fa-xmark-circle text-danger' }} fs-2"></i>
                            </td>
                            <td><span class="badge badge-primary">{{ $user->current_level }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        @endif
    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

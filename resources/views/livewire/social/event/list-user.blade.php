<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des participant</h3>
        @if($event->participants()->count() > 0)
        <div class="card-toolbar gap-2">
            <div class="position-relative w-250px">
                <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un utilisateur..." data-kt-search-element="input">
            </div>
            <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if($event->participants()->count() > 0)
            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info  rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Identifiant</x-base.table-header>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-30px symbol-circle me-5">
                                        <img src="{{ $user->socials()->first()->avatar }}" alt="{{ $user->name }}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bolder">{{ $user->name }}</span>
                                        <div class="text-muted">Tag #{{ shortUserTag($user->uuid) }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-base.is-null
                text="Aucun participant" />
        @endif
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
